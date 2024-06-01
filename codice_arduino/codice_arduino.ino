#include <SPI.h>
#include <MFRC522.h>
#include <ESP32Servo.h>
#include <WiFi.h>
#include <HTTPClient.h>
#include <WebServer.h>

// Definizione dei pin
#define SS_PIN 21    
#define RST_PIN 22   
#define REDLED 2     
#define ButtonPin2 25
#define buzzerPin 12 
#define ButtonPin 4
#define echoPin 34            
#define trigPin 0
#define servoPin 5  

// Variabili di stato
static int allarm = 0;
static int controllo = 0;
static int porta = 1; 
bool locked = false;

// Credenziali WiFi
const char* ssid = "VodafoneMIA";
const char* password = "Lavezzi2@";

// Oggetti delle librerie
MFRC522 mfrc522(SS_PIN, RST_PIN);  // Crea l'istanza MFRC522.
WebServer server(80);              // Crea il server web.
Servo myServo;                     // Crea l'istanza Servo.

// Funzione per gestire l'apertura e chiusura del servo tramite richiesta HTTP
void handleSetServo() {
    if (locked) {
        myServo.write(100);
        server.send(200, "text/plain", "Servo aperto");
    } else {
        myServo.write(15);
        server.send(200, "text/plain", "Servo chiuso");
    }
    locked = !locked; // Alterna lo stato di blocco

    HTTPClient http;
    http.begin("http://192.168.1.21/progettoIOT/control.php?uid=83%20AC%20AF%200D");
    int httpResponseCode = http.GET();
    http.end();
}

// Funzione per disattivare l'allarme tramite richiesta HTTP
void handleDisableAlarm() {
    myServo.attach(servoPin);
    allarm = 0;
    server.send(200, "text/plain", "Allarme disattivato");

    if (WiFi.status() == WL_CONNECTED) {
        HTTPClient http;
        http.begin("http://192.168.1.21/progettoIOT/control.php?allarme=disattivato");
        int httpResponseCode = http.GET();

        if (httpResponseCode > 0) {
            Serial.print("Codice risposta HTTP: ");
            Serial.println(httpResponseCode);
        } else {
            Serial.print("Errore durante la richiesta HTTP: ");
            Serial.println(httpResponseCode);
        }

        http.end();
    } else {
        Serial.println("WiFi disconnesso");
    }
}

// Funzione di setup per inizializzare il sistema
void setup() {
    Serial.begin(9600); 
    WiFi.begin(ssid, password);

    while (WiFi.status() != WL_CONNECTED) {
        delay(1000);
        Serial.println("Connessione al WiFi in corso...");
    }

    Serial.println("Connesso al WiFi");
    Serial.print("Indirizzo IP: ");
    Serial.println(WiFi.localIP());

    // Configurazione dei pin
    pinMode(buzzerPin, OUTPUT);
    pinMode(ButtonPin, OUTPUT);  
    pinMode(ButtonPin2, OUTPUT); 
    pinMode(trigPin, OUTPUT);
    pinMode(echoPin, INPUT); 
    pinMode(REDLED, OUTPUT);
    
    // Inizializzazione delle librerie
    SPI.begin();         
    mfrc522.PCD_Init();  
    mfrc522.PCD_DumpVersionToSerial();

    myServo.attach(servoPin);  

    // Configurazione del server web
    server.on("/set_servo", handleSetServo);
    server.on("/disable_alarm", handleDisableAlarm);
    server.begin();
}

// Funzione loop che gestisce il comportamento principale del sistema
void loop() {
    server.handleClient();

    if (controllo == 1) {
        allarme();
    } else {
        if (allarm == 1) {
            myServo.attach(servoPin);
        }
        Serial.println("Allarme Disattivato");
        noTone(buzzerPin);
        digitalWrite(REDLED, LOW);
        allarm = 0;
        delay(1000);
    }

    if (!mfrc522.PICC_IsNewCardPresent()) {
        return;
    }

    if (!mfrc522.PICC_ReadCardSerial()) {
        return;
    }

    Serial.println();
    Serial.print(" UID tag :");
    String content = "";
    for (byte i = 0; i < mfrc522.uid.size; i++) {
        Serial.print(mfrc522.uid.uidByte[i] < 0x10 ? " 0" : " ");
        Serial.print(mfrc522.uid.uidByte[i], HEX);
        content.concat(String(mfrc522.uid.uidByte[i] < 0x10 ? " 0" : " "));
        content.concat(String(mfrc522.uid.uidByte[i], HEX));
    }
    content.toUpperCase();
    Serial.println();

    if (content.substring(1) == "83 AC AF 0D") {
        if (locked) {
            myServo.write(110);
            controllo = 1;
        } else {
            myServo.write(15);
            controllo = 0;
        }

        locked = !locked;

        if (WiFi.status() == WL_CONNECTED) {
            HTTPClient http;
            http.begin("http://192.168.1.21/progettoIOT/control.php?uid=83%20AC%20AF%200D");
            int httpResponseCode = http.GET();

            if (httpResponseCode > 0) {
                Serial.print("Codice risposta HTTP: ");
                Serial.println(httpResponseCode);
                String payload = http.getString();
                Serial.println("Risposta server: " + payload);
            } else {
                Serial.print("Codice errore: ");
                Serial.println(httpResponseCode);
            }
            http.end();
        } else {
            Serial.println("WiFi Disconnesso");
        }
    } else {
        digitalWrite(REDLED, HIGH);
    }

    delay(2000);
}

// Funzione per gestire l'allarme basato sulla distanza rilevata dal sensore ultrasonico
void allarme() {
    digitalWrite(trigPin, LOW);
    delayMicroseconds(2);
    digitalWrite(trigPin, HIGH);
    delayMicroseconds(10);
    digitalWrite(trigPin, LOW);

    duration = pulseIn(echoPin, HIGH);
    distance = duration / 58.2;
    String disp = String(distance);

    Serial.print("Distanza: ");
    Serial.print(disp);
    Serial.println(" cm");

    delay(1000);

    if (distance < 50) {
        allarm = 1;
        myServo.detach();
    } 
    if (allarm == 1) {
        tone(buzzerPin, 200);
        digitalWrite(REDLED, HIGH);
        delay(100);
        digitalWrite(REDLED, LOW);
        delay(100);
        val = digitalRead(ButtonPin);
        if (val == 1) {
            myServo.attach(servoPin);
            allarm = 0;
        }
    } else if (allarm == 0) {
        noTone(buzzerPin);
        digitalWrite(REDLED, LOW);
        delay(1000);
    }
}
