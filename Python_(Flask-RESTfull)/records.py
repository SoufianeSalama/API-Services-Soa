from flask import Flask, request
from flask_restful import Resource, Api
from flask_restful_swagger import swagger

import mysql.connector

app = application  = Flask(__name__)
api = swagger.docs(Api(app), apiVersion='0.1')

class Record(Resource):
    mydb = ""
    def __init__(self):
        self.mydb = mysql.connector.connect(
            host="soacl-database.cjn6wctbjclb.us-east-1.rds.amazonaws.com",
            user="administrator",
            passwd="fLrsZEBnnc4QD35",
            database="soa_project"
        )
    "Record API"
    @swagger.operation(
        notes='Get a record by SORD',
        nickname='get',
        # Parameters can be automatically extracted from URLs (e.g. <string:id>)
        # but you could also override them here, or add other parameters.
        parameters=[
        {
            "name": "sord",
            "description": "The SORD of the record",
            "required": True,
            "allowMultiple": False,
            "dataType": 'string',
            "paramType": 'path'
        }
    ])
    def get(self, sord):
        # Get a device with id (GET)
        mycursor = self.mydb.cursor()
        sql = "SELECT * FROM records WHERE sord=" + str(sord)
        mycursor.execute(sql)

        records = mycursor.fetchall()
        if records:
            record = records[0]
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
        else:
            returnData = []

        return returnData

    @swagger.operation(
        notes='Delete a record by SORD',
        nickname='delete',
        # Parameters can be automatically extracted from URLs (e.g. <string:id>)
        # but you could also override them here, or add other parameters.
        parameters=[
            {
                "name": "sord",
                "description": "The SORD of the record",
                "required": True,
                "allowMultiple": False,
                "dataType": 'string',
                "paramType": "path"
            }
        ])
    def delete(self,sord):
        # Delete a record (DELETE)
        mycursor = self.mydb.cursor()
        sql = "DELETE FROM records WHERE sord = " + str(sord)
        mycursor.execute(sql)
        self.mydb.commit()
        return "ok"

    @swagger.operation(
        notes='Update a record by SORD',
        nickname='put',
        # Parameters can be automatically extracted from URLs (e.g. <string:id>)
        # but you could also override them here, or add other parameters.
        parameters=[
            {
                "name": "sord",
                "description": "The SORD of the record",
                "required": True,
                "allowMultiple": False,
                "dataType": 'string',
                "paramType": "path"
            },
            {
                "name": "diagnose",
                "description": "The DIAGNOSE of the manufacturer",
                "required": True,
                "allowMultiple": False,
                "dataType": 'string',
                "paramType": "form"
            },
            {
                "name": "statuskey",
                "description": "The STATUS KEY of the device",
                "required": True,
                "allowMultiple": False,
                "dataType": 'int',
                "paramType": "form"
            }
        ])
    def put(self, sord):
        # Update a device (UPDATE)
        record = []
        record.append(request.form['diagnose'])
        record.append(request.form['statuskey'])
        #record.append(request.form['userid'])
        mycursor = self.mydb.cursor()
        sql = "UPDATE records SET diagnose = %s, statuskey = %s WHERE sord = %s"
        val = (record[0], record[1], str(sord))
        mycursor.execute(sql, val)
        self.mydb.commit()
        return "ok"



# Get All Devices (READ -> get)
class Records(Resource):
    mydb = ""
    def __init__(self):
        self.mydb = mysql.connector.connect(
            host="soacl-database.cjn6wctbjclb.us-east-1.rds.amazonaws.com",
            user="administrator",
            passwd="fLrsZEBnnc4QD35",
            database="soa_project"
        )

    @swagger.operation(
        notes='Get all records',
        nickname='get',
        )
    def get(self):
        mycursor = self.mydb.cursor()
        mycursor.execute("SELECT * FROM records")

        records = mycursor.fetchall()
        returnData = []
        if records:
            for record in records:
                deviceJSON = {
                    "sord": record[0],
                    "devicesn": record[1],
                    "brand": record[2],
                    "clientinfo": record[3],
                    "clientaddress": record[4],
                    "complaint": record[5],
                    "diagnose": record[6],
                    "statuskey": record[7],
                    "userid": record[8]
                };
                returnData.append(deviceJSON)

        return returnData

    @swagger.operation(
        notes='Create a new record',
        nickname='put',
        # Parameters can be automatically extracted from URLs (e.g. <string:id>)
        # but you could also override them here, or add other parameters.
        parameters=[
            {
                "name": "brand",
                "description": "The BRAND of the device",
                "required": True,
                "allowMultiple": False,
                "dataType": 'string',
                "paramType": "form"
            },
            {
                "name": "devicesn",
                "description": "The DEVICE SERIALNUMBER of the device",
                "required": True,
                "allowMultiple": False,
                "dataType": 'string',
                "paramType": "form"
            },
            {
                "name": "clientinfo",
                "description": "The CLEINT INFO",
                "required": True,
                "allowMultiple": False,
                "dataType": 'string',
                "paramType": "form"
            },
            {
                "name": "clientaddress",
                "description": "The CLIENT ADDRESS",
                "required": True,
                "allowMultiple": False,
                "dataType": 'string',
                "paramType": "form"
            },
            {
                "name": "complaint",
                "description": "The COMPLAINT of the device",
                "required": True,
                "allowMultiple": False,
                "dataType": 'string',
                "paramType": "form"
            },
            {
                "name": "diagnose",
                "description": "The DIAGNOSE of the manufacturer",
                "required": True,
                "allowMultiple": False,
                "dataType": 'string',
                "paramType": "form"
            },
            {
                "name": "statuskey",
                "description": "The STATUS KEY of the device",
                "required": True,
                "allowMultiple": False,
                "dataType": 'int',
                "paramType": "form"
            },
            {
                "name": "userid",
                "description": "The USER ID of the manufacturer",
                "required": True,
                "allowMultiple": False,
                "dataType": 'int',
                "paramType": "form"
            }

        ])
    def post(self):
        # Create a new device (POST)
        record = [];
        #record.append(request.form['sord'])
        record.append(request.form['brand'])
        record.append(request.form['devicesn'])
        record.append(request.form['clientinfo'])
        record.append(request.form['clientaddress'])
        record.append(request.form['complaint'])
        record.append(request.form['diagnose'])
        record.append(request.form['statuskey'])
        record.append(request.form['userid'])
        ### Hier zou eerst nog form validation moeten gedaan worden
        ### controle of er al een toestel met hetzelfde id of serienummer bestaat
        ### id is hetzelfde als een dossiernummer, serienummer is uniek voor elk toestel (staat op een artiekelticket
        ### controle op SQL injectie

        sql = "INSERT INTO records (brand, devicesn, clientinfo, clientaddress, complaint, diagnose, statuskey, userid) " \
              "VALUES (%s, %s, %s, %s, %s, %s, %s, %s)"
        val = (record[0], record[1], record[2], record[3], record[4], record[5], record[6], record[7])
        mycursor = self.mydb.cursor()
        mycursor.execute(sql, val)

        self.mydb.commit()

        return "ok"
