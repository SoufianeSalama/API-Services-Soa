using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using MySql.Data.MySqlClient;

// met hulp van: https://www.codeproject.com/Articles/43438/Connect-C-to-MySQL
public class DatabaseConnector
{
    private string server, database, username, password;
    private MySqlConnection connection;

    public DatabaseConnector()
    {
        Initialize();
    }

    private void Initialize()
    {
        server = "soacl-database.cjn6wctbjclb.us-east-1.rds.amazonaws.com";
        database = "soa_project";
        username = "administrator";
        password = "fLrsZEBnnc4QD35";
       /*server = "localhost";
        database = "soa_project";
        username = "root";
        password = "";*/

        string connectionString = "SERVER=" + server + ";" + "DATABASE=" +
            database + ";" + "UID=" + username + ";" + "PASSWORD=" +password + ";";

        connection = new MySqlConnection(connectionString);
    }

    private bool OpenConnection()
    {
        try
        {
            connection.Open();
            return true;
        }
        catch(MySqlException exception)
        {
            switch(exception.Number)
            {
                case 0:
                    // kan geen connectie maken met database
                    break;
                case 1:
                    // foute logingegevens
                    break;
            }
            return false;
        }
    }

    private bool CloseConnection()
    {
        try
        {
            connection.Close();
            return true;
        }
        catch(MySqlException exception)
        {
            // andere fouten
            return false;
        }
    }

    //public List<string>[] Select()
    public List<DevicePart> SelectPart(string partsn)
    {
        string query = "";
        if (String.IsNullOrEmpty(partsn)){
            query = "SELECT * FROM deviceparts";
        }
        else
        {
            query = "SELECT * FROM deviceparts WHERE deviceparts.sn = '" + partsn + "'";
        }
        
        List<DevicePart> list = new List<DevicePart>();
  
        if (OpenConnection() == true)
        {
            MySqlCommand command = new MySqlCommand(query, connection);
            MySqlDataReader dataReader = command.ExecuteReader();

            while (dataReader.Read())
            {
                DevicePart dp = new DevicePart();
                dp.serialnumber = dataReader["sn"].ToString();
                dp.brand = dataReader["brand"].ToString();
                dp.description = dataReader["description"].ToString();
                dp.availability = dataReader["available"].ToString();
                dp.partid = Convert.ToInt32(dataReader["partid"]); //casten werkt niet
                dp.price = (float)dataReader["price"];
                list.Add(dp);
            }

            dataReader.Close();
            CloseConnection();
            return list;
        }
        else
        {
            return list;
        }
    }

    public List<Device> SelectDevice(string devicesn)
    {
        string query = "";
        if (!String.IsNullOrEmpty(devicesn))
        {
            query = "SELECT * FROM devices WHERE devices.sn = '" + devicesn + "'";
        }

        List<Device> list = new List<Device>();

        if (OpenConnection() == true)
        {
            MySqlCommand command = new MySqlCommand(query, connection);
            MySqlDataReader dataReader = command.ExecuteReader();

            while (dataReader.Read())
            {
                Device d = new Device();
                d.serialnumber = dataReader["sn"].ToString();
                d.brand = dataReader["brand"].ToString();
                d.description = dataReader["description"].ToString();
                d.mainboard = dataReader["mainboard"].ToString();
                d.powerboard = dataReader["powerboard"].ToString();
                d.tconboard = dataReader["tconboard"].ToString();
                d.price = (float)dataReader["price"];
                list.Add(d);
            }

            dataReader.Close();
            CloseConnection();
            return list;
        }
        else
        {
            return list;
        }
    }

    public List<DevicePart> getParts(string devicesn)
    {
        string query = @"SELECT
                deviceparts.sn AS 'partSN',
                deviceparts.available,
                deviceparts.price,
                deviceparts.description
            FROM
                devices
            INNER JOIN deviceparts
            ON devices.mainboard = deviceparts.sn
            OR devices.tconboard = deviceparts.sn
            OR devices.powerboard = deviceparts.sn
            WHERE devices.sn = '" + devicesn + "'";

        List<DevicePart> list = new List<DevicePart>();

        if (OpenConnection() == true)
        {
            MySqlCommand command = new MySqlCommand(query, connection);
            MySqlDataReader dataReader = command.ExecuteReader();

            while (dataReader.Read())
            {
                DevicePart dp = new DevicePart();
                dp.serialnumber = dataReader["partSN"].ToString();
                dp.description = dataReader["description"].ToString();
                dp.price = (float)dataReader["price"];
                dp.availability = dataReader["available"].ToString();
                list.Add(dp);
            }

            dataReader.Close();
            CloseConnection();
            return list;
        }
        else
        {
            return list;
        }
    }
}