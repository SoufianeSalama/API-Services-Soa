from flask import Flask, request
from flask_restful import Resource, Api
import mysql.connector

class Record(Resource):
    mydb = ""
    def __init__(self):
        self.mydb = mysql.connector.connect(
            host="localhost",
            user="root",
            passwd="",
            database="soa_project"
        )
    def get(self, num):
        # Get a device with id (GET)
        mycursor = self.mydb.cursor()
        sql = "SELECT * FROM records WHERE sord=" + str(num)
        mycursor.execute(sql)

        record = mycursor.fetchall()[0]
        print(record)
        recordJSON = {
            "sord": record[0],
            "devicesn": record[1],
            "brand": record [2],
            "clientinfo": record[3],
            "clientaddress": record[4],
            "complaint": record[5],
            "diagnose": record[6],
            "statuskey": record[7],
            "userid": record[8]
        };
        returnData = []
        returnData.append(recordJSON)
        return returnData

    def delete(self,num):
        # Delete a record (DELETE)
        mycursor = self.mydb.cursor()
        sql = "DELETE FROM records WHERE sord = " + str(num)
        mycursor.execute(sql)
        self.mydb.commit()
        return "ok"

    def put(self, num):
        # Update a device (UPDATE)
        record = []
        record.append(request.form['diagnose'])
        record.append(request.form['statuskey'])
        #record.append(request.form['userid'])

        #mycursor = self.mydb.cursor()

        #sql = "UPDATE records SET diagnose = %s, statuskey = %s, userid = %s WHERE sord = %s"
        #val = (record[0], record[1], record[2], str(num))

        #sql = "UPDATE records SET diagnose = %s, statuskey = %s WHERE sord = %s"
        #val = (record[0], record[1], str(num))
        #mycursor.execute(sql, val)

        #self.mydb.commit()

        return "ok"

# Get All Devices (READ -> get)
class Records(Resource):
    mydb = ""
    def __init__(self):
        self.mydb = mysql.connector.connect(
            host="localhost",
            user="root",
            passwd="",
            database="soa_project"
        )
    def get(self):
        mycursor = self.mydb.cursor()
        mycursor.execute("SELECT * FROM records")

        records = mycursor.fetchall()
        returnData = []
        for record in records:
            deviceJSON = {
                "sord": record[0],
                "devicesn": record[1],
                "brand": record [2],
                "clientinfo": record[3],
                "clientaddress": record[4],
                "complaint": record[5],
                "diagnose": record[6],
                "statuskey": record[7],
                "userid": record[8]
            };
            returnData.append(deviceJSON)
        return returnData


    def post(self):
        # Create a new device (POST)
        record = [];
        #record.append(request.form['sord'])
        record.append(request.form['devicesn'])
        record.append(request.form['clientinfo'])
        record.append(request.form['complaint'])
        record.append(request.form['diagnose'])
        record.append(request.form['statuskey'])
        record.append(request.form['userid'])
        ### Hier zou eerst nog form validation moeten gedaan worden
        ### controle of er al een toestel met hetzelfde id of serienummer bestaat
        ### id is hetzelfde als een dossiernummer, serienummer is uniek voor elk toestel (staat op een artiekelticket
        ### controle op SQL injectie

        sql = "INSERT INTO records (devicesn, clientinfo, complaint, diagnose, statuskey, userid) " \
              "VALUES (%s, %s, %s, %s,%s, %s)"
        val = (record[0], record[1], record[2], record[3], record[4], record[5])
        mycursor = self.mydb.cursor()
        mycursor.execute(sql, val)

        self.mydb.commit()
        return "ok"


