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
        server = "localhost";
        database = "soa_project";
        username = "root";
        password = "";

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
    public List<DevicePart> Select()
    {
        string query = "SELECT * FROM deviceparts";
        List<DevicePart> list = new List<DevicePart>();
        

        /* 
        List<string>[] list = new List<string>[6];
        list[0] = new List<string>(); // S/N        (serieummer onderdeel)
        list[1] = new List<string>(); // Brand 
        list[2] = new List<string>(); // Description
        list[3] = new List<string>(); // Available  (0=nietbeschik/1=beschik)
        list[4] = new List<string>(); // Partid     (0=mainboard; 1=powerboard; 2=tcon; 3=scherm; 4=wifi; 5=afstandsbediening
        list[5] = new List<string>(); // Price
        */


        if (OpenConnection() == true)
        {
            MySqlCommand command = new MySqlCommand(query, connection);
            MySqlDataReader dataReader = command.ExecuteReader();

            while (dataReader.Read())
            {
                /*list[0].Add(dataReader["sn"] + "");
                list[1].Add(dataReader["brand"] + "");
                list[2].Add(dataReader["description"] + "");
                list[3].Add(dataReader["available"] + "");
                list[4].Add(dataReader["partid"] + "");
                list[5].Add(dataReader["price"] + "");*/

                DevicePart dp = new DevicePart();
                dp.serialnumber = dataReader["sn"].ToString();
                dp.brand = dataReader["brand"].ToString();
                dp.description = dataReader["description"].ToString();
                dp.availability = (bool)((int)dataReader["available"]));
                dp.partid = (int)dataReader["partid"];
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
}