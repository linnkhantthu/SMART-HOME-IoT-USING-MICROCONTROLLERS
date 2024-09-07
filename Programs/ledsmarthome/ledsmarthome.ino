#include <WiFiClientSecure.h>
#include <ESP8266WiFi.h>
#include <Arduino.h>
//#include <ESP8266WiFi.h>
#include <ESP8266WiFiMulti.h>
#include <ESP8266HTTPClient.h>
#include <ArduinoJson.h>
#include <WiFiClient.h>

const char server[] = "lktsmarthome.000webhostapp.com"; // www.example.com
String uri = "/smarthome/ledControl.php";
const char* ssid = "LKT";
const char* ssidpw = "lkt78699";
const char* status1="";
const char* status2="";
const char* status3="";
const char* status4="";
const char* status5="";
const char* status6="";
const char* status7="";
const char* json="";
String myStatus1="";
String myStatus2="";
String myStatus3="";
String myStatus4="";
String myStatus5="";
String myStatus6="";
String myStatus7="";
WiFiClient client;
bool connected = false;
void setup() {
  Serial.begin(9600);
  connectWifi();
  pinMode(16,OUTPUT);
  pinMode(5,OUTPUT);
  pinMode(4,OUTPUT);
  pinMode(0,OUTPUT);
  pinMode(2,OUTPUT);
  pinMode(14,OUTPUT);
  pinMode(12,OUTPUT);
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

void getData(){
  if(client.connect(server, 80)){
    Serial.println("TCP connection ready");
    //client.print("GET " + uri + " HTTP/1.0\r\n" +"Host: " + server + "\r\n" +"Accept: *" + "/" + "*\r\n" +"Content-Length: " + data.length() + "\r\n" +"Content-Type: application/x-www-form-urlencoded\r\n" +"\r\n" + data);
    client.print("GET ");
    client.print(uri);
    client.println(" HTTP/1.1");
    client.print("Host: ");
    client.println(server);
    client.println("Content-Type: application/json");
    client.println();
    delay(5000);
  }
  if(client.available()){
      const size_t capacity = JSON_ARRAY_SIZE(1) + 7*JSON_OBJECT_SIZE(1) + JSON_OBJECT_SIZE(7);
      DynamicJsonBuffer jsonBuffer(capacity);

      client.readStringUntil('[');
      String str = client.readStringUntil(']');
      json = str.c_str();
      Serial.println(json);

      JsonObject& root = jsonBuffer.parseObject(json);

      status1 = root["1"]["status"]; // "ON"
      status2 = root["2"]["status"]; // "LOW" 
      status3 = root["3"]["status"]; // "ON"
      status4 = root["4"]["status"]; // "LOW" 
      status5 = root["5"]["status"]; // "ON"
      status6 = root["6"]["status"]; // "LOW" 
      status7 = root["7"]["status"]; // "ON"
  }
  Serial.println(status1);
  Serial.println(status2);
  myStatus1 = String(myStatus1+status1);
  myStatus2 = String(myStatus2+status2);
  myStatus3 = String(myStatus3+status3);
  myStatus4 = String(myStatus4+status4);
  myStatus5 = String(myStatus5+status5);
  myStatus6 = String(myStatus6+status6);
  myStatus7 = String(myStatus7+status7);
  Serial.println(myStatus1);
  Serial.println(myStatus2);
  Serial.println(myStatus3);
  Serial.println(myStatus4);
  Serial.println(myStatus5);
  Serial.println(myStatus6);
  Serial.println(myStatus7);
}

void checkConnection(){
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
    connected = false;
  }

  connected = true;

}

void loop() {
  myStatus1="";
  myStatus2="";
  myStatus3="";
  myStatus4="";
  myStatus5="";
  myStatus6="";
  myStatus7="";
  getData();
  delay(7000);
  if(myStatus1=="ON"){
    //Serial.println("The light is ON");
    digitalWrite(16,HIGH);
  }
  if(myStatus1=="OFF"){
    //Serial.println("The light is OFF");
    digitalWrite(16,LOW);
  }

  if(myStatus2=="ON"){
    //Serial.println("The light is ON");
    digitalWrite(5,HIGH);
  }
  if(myStatus2=="OFF"){
    //Serial.println("The light is OFF");
    digitalWrite(5,LOW);
  }

  if(myStatus3=="ON"){
    //Serial.println("The light is ON");
    digitalWrite(4,HIGH);
  }
  if(myStatus3=="OFF"){
   // Serial.println("The light is OFF");
    digitalWrite(4,LOW);
  }

  if(myStatus4=="ON"){
    //Serial.println("The light is ON");
    digitalWrite(0,HIGH);
  }
  if(myStatus4=="OFF"){
   // Serial.println("The light is OFF");
    digitalWrite(0,LOW);
  }

  if(myStatus5=="ON"){
    //Serial.println("The light is ON");
    digitalWrite(2,HIGH);
  }
  if(myStatus5=="OFF"){
    //Serial.println("The light is OFF");
    digitalWrite(2,LOW);
  }

  if(myStatus6=="ON"){
    //Serial.println("The light is ON");
    digitalWrite(14,HIGH);
  }
  if(myStatus6=="OFF"){
    //Serial.println("The light is OFF");
    digitalWrite(14,LOW);
  }

  if(myStatus7=="ON"){
    //Serial.println("The light is ON");
    digitalWrite(12,HIGH);
  }
  if(myStatus7=="OFF"){
    //Serial.println("The light is OFF");
    digitalWrite(12,LOW);
  }
  client.stop();
  delay(1000);
}
