using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Services;

/// <summary>
/// Summary description for SoapWebService
/// </summary>
[WebService(Namespace = "http://homepi.ga/")]
[WebServiceBinding(ConformsTo = WsiProfiles.BasicProfile1_1)]
// To allow this Web Service to be called from script, using ASP.NET AJAX, uncomment the following line. 
// [System.Web.Script.Services.ScriptService]
public class SoapWebService : System.Web.Services.WebService
{
    private DatabaseConnector dbconn; 
    public SoapWebService()
    {
        dbconn = new DatabaseConnector();
        //Uncomment the following line if using designed components 
        //InitializeComponent(); 
    }

    [WebMethod]
    public string HelloWorld()
    {
        return "Hello World";
    }

    [WebMethod]
    public List<DevicePart> AllParts()
    {
        List<DevicePart> parts = dbconn.SelectPart("");
        return parts;
    }

    [WebMethod]
    public List<DevicePart> SpecificPart(string partSN)
    {
        List<DevicePart> parts = dbconn.SelectPart(partSN); // SN = serienummer
        return parts;
    }

    [WebMethod]
    public List<Device> PartsOfDevice(string deviceSN)
    {
        // deze toont de gebruiker de gebruikte onderdelen in een bepaald toestel, zodat ze deze kunnen bestellen
        List<Device> parts = dbconn.SelectDevice(deviceSN); // SN = serienummer
        return parts;
    }

   
}
