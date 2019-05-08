from flask import Flask, request
from flask_restful import Resource, Api
import mysql.connector

# Get All Devices (READ -> get)
class AllDevices(Resource):
    def get(self):
        mydb = mysql.connector.connect(
            host="localhost",
            user="root",
            passwd="",
            database = "soa_project"
        )
        mycursor = mydb.cursor()
        mycursor.execute("SELECT * FROM devices")

        devices = mycursor.fetchall()
        returnData = []
        for device in devices:
            print(device)
            deviceJSON = {
                "id": device[0],
                "name": device[1],
                "description": device[2],
                "serialnumber": device[3],
                "client": device[4],
                "workerid": device[5],
                "complaint": device[6],
                "diagnose" : device[7],
                "status": device[8]
            };
            returnData.append(deviceJSON)
        return returnData

# Get A Specific Device From DeviceID (READ -> get)
class Device(Resource):
    def get(self, num):
        mydb = mysql.connector.connect(
            host="localhost",
            user="root",
            passwd="",
            database="soa_project"
        )
        mycursor = mydb.cursor()
        sql = "SELECT * FROM devices WHERE id=" + str(num)
        mycursor.execute(sql)

        devices = mycursor.fetchall()
        returnData = []
        for device in devices:
            print(device)
            deviceJSON = {
                "id": device[0],
                "name": device[1],
                "description": device[2],
                "serialnumber": device[3],
                "client": device[4],
                "workerid": device[5],
                "complaint": device[6],
                "diagnose": device[7],
                "status": device[8]
            };
            returnData.append(deviceJSON)
        return returnData

# Save A New Device(CREATE -> post niet put)
class NewDevice(Resource):
    def post(self):

        device = []
        device.append(request.form['id'])
        device.append(request.form['name'])
        device.append(request.form['description'])
        device.append(request.form['serialnumber'])
        device.append(request.form['client'])
        device.append(request.form['workerid'])
        device.append(request.form['complaint'])
        device.append(request.form['diagnose'])
        device.append(request.form['status'])

        print(device[0])

        ### Hier zou eerst nog form validation moeten gedaan worden
        ### controle of er al een toestel met hetzelfde id of serienummer bestaat
        ### id is hetzelfde als een dossiernummer, serienummer is uniek voor elk toestel (staat op een artiekelticket
        ### controle op SQL injectie

        mydb = mysql.connector.connect(
            host="localhost",
            user="root",
            passwd="",
            database="soa_project"
        )
        mycursor = mydb.cursor()

        sql = "INSERT INTO devices (id, name, description, serialnumber, client, worker_id, complaint, diagnose, status) " \
              "VALUES (%s, %s, %s, %s,%s, %s, %s, %s, %s)"
        val = (device[0], device[1], device[2], device[3], device[4], device[5], device[6], device[7], device[8] )
        mycursor.execute(sql, val)

        mydb.commit()

        return "ok"

class DeleteDevice(Resource):
    def delete(self, num):
        mydb = mysql.connector.connect(
            host="localhost",
            user="root",
            passwd="",
            database="soa_project"
        )
        mycursor = mydb.cursor()
        sql = "DELETE FROM devices WHERE id = " + str(num)
        mycursor.execute(sql)

        mydb.commit()

        return "ok"

# Update A Device(UPDATE -> put niet post)
# Enkel het 'worker_id', 'diagnos' en 'status' velden kunnen/worden geupdate
class UpdateDevice(Resource):
    def put(self, num):

        device = []
        #device.append(request.form['id'])
        #device.append(request.form['name'])
        #device.append(request.form['description'])
        #device.append(request.form['serialnumber'])
        #device.append(request.form['client'])
        device.append(request.form['workerid'])
        #device.append(request.form['complaint'])
        device.append(request.form['diagnose'])
        device.append(request.form['status'])

        print(device[0])

        ### Hier zou eerst nog form validation moeten gedaan worden
        ### controle of het toestel met dit id of serienummer wel bestaat
        ### id is hetzelfde als een dossiernummer, serienummer is uniek voor elk toestel (staat op een artiekelticket
        ### controle op SQL injectie

        mydb = mysql.connector.connect(
            host="localhost",
            user="root",
            passwd="",
            database="soa_project"
        )
        mycursor = mydb.cursor()

        sql = "UPDATE devices SET worker_id = %s, diagnose = %s, status = %s WHERE id = %s"
        val = (device[0], device[1], device[2], str(num))
        mycursor.execute(sql, val)

        mydb.commit()

        return "ok"


## Ook mogelijk om 1 klasse aan te maken met de verschillende functies; put, get, delete, post, put

# class Device(Resource):
#     def get(self):
#         return ''
#     def post(self):
#         return ''
#     def put(self):
#         return ''
#     def get(self):
#         return ''


