#include <WiFiClientSecure.h>
#include <ESP8266WiFi.h>
#include <Arduino.h>
#include <ESP8266WiFi.h>
#include <ESP8266WiFiMulti.h>
#include <ESP8266HTTPClient.h>
#include <ArduinoJson.h>
#include <WiFiClient.h>
String data="";
const char server[] = "lktsmarthome.000webhostapp.com"; // www.example.com
String uri = "/smarthome/insert.php";
const char* ssid = "LKT";
const char* ssidpw = "lkt78699";
WiFiClient client;
bool connected = false;
int alarmPin=4;
#include <dht11.h>
#define DHT11PIN 5
dht11 DHT11;
float temperature;
float humidity;
int smokePin=A0;
void setup() {
  Serial.begin(9600);
  connectWifi();
  pinMode(5,INPUT);
  pinMode(4,OUTPUT);
  pinMode(0,INPUT);
  pinMode(14,INPUT);
  Serial.println(analogRead(smokePin));
  delay(1000);
  Serial.println(analogRead(smokePin));
  delay(1000);
  Serial.println(analogRead(smokePin));
  delay(1000);
}
void connectWifi()
{
  WiFi.begin(ssid, ssidpw);
  Serial.println();
  Serial.print("Connecting to: ");
  Serial.print(ssid);
  checkConnection();

  if (connected == true){
      Serial.println();
      Serial.print("Connected to: ");
      Serial.print(ssid);
      Serial.println();
      Serial.print("Local IP address: ");
      Serial.print(WiFi.localIP());
  }

  delay(4000);
}

void postData(){
  if(client.connect(server, 80)){
    Serial.println("TCP connection ready");
    client.print("POST " + uri + " HTTP/1.0\r\n" +"Host: " + server + "\r\n" +"Accept: *" + "/" + "*\r\n" +"Content-Length: " + data.length() + "\r\n" +"Content-Type: application/x-www-form-urlencoded\r\n" +"\r\n" + data);
    client.println();
    delay(5000);
    client.stop();
  }
}

void checkConnection(){
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
    connected = false;
  }

  connected = true;

}
/***********************************
**************temperature***********
************************************/
void temperatureReader(){
  int chk = DHT11.read(DHT11PIN);
  if((temperature==(float)DHT11.temperature) && (humidity==(float)DHT11.humidity)){
    temperature=temperature;
    humidity=humidity;
  }
  else{
    temperature = (float)DHT11.temperature;
    humidity = (float)DHT11.humidity;
    data = "temp="+(String)temperature+"&hum="+(String)humidity;
    postData();
  }
  delay(1000);
}
/***********************************
**********End temperature***********
************************************/

/***********************************
****************Smoke***************
***********************************/
void smokeDetector(){
  Serial.println(analogRead(smokePin));
  if(analogRead(smokePin)>400){
    digitalWrite(alarmPin,HIGH);
    data = "smoke=Smoke detected!";
    postData();
  }
  else{
    digitalWrite(alarmPin,LOW);
    data = "smoke=Smoke not Detected!";
    postData();
  }
  delay(5000);
}
/***********************************
**************End Smoke*************
************************************/

/***********************************
**************Flame*****************
************************************/
void flameDetector(){
  if(digitalRead(0)==1){
    digitalWrite(alarmPin,LOW);
    data = "flame=Flame Not Detected!";
    postData();
  }
  else{
    digitalWrite(alarmPin,HIGH);
    data = "flame=Flame Detected!";
    postData();
  }
}
/***********************************
**************End Flame*************
************************************/

/***********************************
**************Vibration*************
************************************/
void vibrationDetector(){
  if(digitalRead(14)==0)
  {
     digitalWrite(alarmPin,LOW);
    data = "vibrate=Vibrate Not Detected!";
    postData();
    
  }
  else
  {
    digitalWrite(alarmPin,HIGH);
    data = "vibrate=Vibrate Detected!";
    postData();
    
  }
}
/***********************************
**************End Vibration*********
************************************/

void loop() {
  temperatureReader();
  smokeDetector();
  flameDetector();
  vibrationDetector();
}
