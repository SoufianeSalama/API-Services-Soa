from flask import Flask, request
from flask_restful import Resource, Api
from records import Record, Records
from flask_restful_swagger import swagger


app = application = Flask(__name__)
api = Api(app)

###################################
# Wrap the Api with swagger.docs. It is a thin wrapper around the Api class that adds some swagger smarts
api = swagger.docs(Api(app), apiVersion='0.1')
###################################


# api.add_resource(AllDevices, "/api/devices")
# api.add_resource(Device, "/api/devices/<int:num>")
# api.add_resource(NewDevice, "/api/devices")
# api.add_resource(DeleteDevice, "/api/devices/<int:num>")
# api.add_resource(UpdateDevice, "/api/devices/<int:num>")


# of makkelijker:
api.add_resource(Record, "/api/records/<int:sord>")
api.add_resource(Records, "/api/records")
#api.add_resource(Welcome, "/")

@app.route('/')
def index():
    return '<html><head><title>Rest Service</title></head>' \
           '<body><div style="margin:auto; text-align:center">' \
           '<h3>Welkom op de Rest Service Api</h3>' \
           '<h5>Door Soufiane Salama voor project SOA-CLOUD <br>' \
           'Klik <a href="/api/spec.html">hier</a> voor de documentatie </h5>' \
           '</body>' \
           '</html>'

if __name__ == '__main__':
    app.run(debug=True)

