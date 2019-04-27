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
    public List<DevicePart> HelloWorld()
    {
        List<DevicePart> parts = dbconn.Select();

        return parts;
    }

    [WebMethod]
    public string getPartsOfDevice(string serienummerToestel)
    {
        return "Hello World";
    }

    [WebMethod]
    public string Ser(string serienummerToestel)
    {
        return "Hello World";
    }
}
