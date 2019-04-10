from flask import Flask
from flask_restful import Resource, Api
from devices import AllDevices, Device, NewDevice, DeleteDevice,UpdateDevice

app = Flask(__name__)
api = Api(app)

class Welcome(Resource):
    def get(self):
        return {
            "hallo":"world"
        }

api.add_resource(Welcome, "/")

api.add_resource(AllDevices, "/api/devices")
api.add_resource(Device, "/api/devices/<int:num>")
api.add_resource(NewDevice, "/api/devices")
api.add_resource(DeleteDevice, "/api/devices/<int:num>")
api.add_resource(UpdateDevice, "/api/devices/<int:num>")

if __name__ == '__main__':
    app.run(debug=True)
