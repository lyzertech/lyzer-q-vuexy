# test_mysql.py
import mysql.connector
from mysql.connector import Error
from datetime import datetime
import time
from modbus_read import read_modbus

def insert_data():

    try:
        # Read from Modbus
        data = read_modbus()
        if not data:
            print("❌ No Modbus data read")
            exit()

        # Connect to MySQL
        connection = mysql.connector.connect(
            host="127.0.0.1",
            user="root",
            password="root",
            database="lyzer-q"
        )

        if connection.is_connected():
            print("✅ Connected to MySQL")

            cursor = connection.cursor()

            sql = """
            INSERT INTO monitoring_acuvim (
                gateway_name, gateway_model, gateway_serial,
                device_name, device_model, device_serial, 
                device_online, Timestamp, Freq_Hz, 
                V1, V2, V3, Vnavg_V, 
                V12, V23, V31, VIavg_V,
                I1, I2, I3, Iavg_A, `In`, 
                P1, P2, P3, Psum_kW,
                Q1, Q2, Q3, Qsum_kvar, 
                S1, S2, S3, Ssum_kVA,
                PF1, PF2, PF3, PF
            ) VALUES (
                %s, %s, %s,
                %s, %s, %s, 
                %s, %s, %s, 
                %s, %s, %s, %s, 
                %s, %s, %s, %s,
                %s, %s, %s, %s, %s, 
                %s, %s, %s, %s,
                %s, %s, %s, %s, 
                %s, %s, %s, %s,
                %s, %s, %s, %s
            )
            """

            values = (
                "Gateway-01", "Model-X", "SN123456",
                "Device-01", "Acuvim-L", "DEV123456", 
                1, datetime.now(), data["Freq_Hz"], 
                data["V1"], data["V2"], data["V3"], data["Vnavg_V"], 
                data["V12"], data["V23"], data["V31"], data["VIavg_V"],
                data["I1"], data["I2"], data["I3"], data["Iavg_A"], data["In"],
                data["P1"], data["P2"], data["P3"], data["Psum_kW"],
                data["Q1"], data["Q2"], data["Q3"], data["Qsum_kvar"],
                data["S1"], data["S2"], data["S3"], data["Ssum_kVA"],
                data["PF1"], data["PF2"], data["PF3"], data["PF"]
            )

            cursor.execute(sql, values)
            connection.commit()
            print("✅ Data inserted into monitoring_acuvim")

            cursor.close()

    except Error as e:
        print("❌ MySQL error:", e)

    finally:
        if 'connection' in locals() and connection.is_connected():
            connection.close()
            print("🔌 MySQL connection closed")
if __name__ == "__main__":
    while True:
        insert_data()
        time.sleep(5)  # ⏱️ delay 5 seconds before next read
