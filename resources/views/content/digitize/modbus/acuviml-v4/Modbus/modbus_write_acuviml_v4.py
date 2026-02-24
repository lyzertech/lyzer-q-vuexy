# modbus_write_acuviml_v4.py
# Device : Accuenergy Acuvim L-V4
# Modbus RTU — COM4 / 9600 baud / unit 1
# Usage  : python modbus_write_acuviml_v4.py <address> <value>

import sys
import json
from pymodbus.client.sync import ModbusSerialClient
from pymodbus.payload import BinaryPayloadBuilder
from pymodbus.constants import Endian

# Addresses that store 16-bit integers (1 register each)
# Registers 4159-4165: Week, Year, Month, Day, Hour, Minute, Second
INT_ADDRESSES = {4159, 4160, 4161, 4162, 4163, 4164, 4165}


def write_register(address, value):
    client = ModbusSerialClient(
        method='rtu',
        port='COM4',
        baudrate=19200,
        bytesize=8,
        parity='N',
        stopbits=1,
        timeout=1
    )

    if client.connect():
        if address in INT_ADDRESSES:
            # FC6 — Write Single Register (most compatible with Accuenergy devices)
            response = client.write_register(address, int(value), unit=1)
        else:
            # FC16 — Write Multiple Registers (32-bit float needs 2 registers)
            builder = BinaryPayloadBuilder(byteorder=Endian.Big, wordorder=Endian.Big)
            builder.add_32bit_float(float(value))
            payload = builder.to_registers()
            response = client.write_registers(address, payload, unit=1)

        client.close()

        if response.isError():
            return {"status": "error", "message": str(response), "address": address}
        else:
            return {"status": "ok", "written": value, "address": address}

    return {"status": "error", "message": "Cannot connect to device on COM4", "address": address}


if __name__ == "__main__":
    if len(sys.argv) != 3:
        print(json.dumps({"status": "error", "message": "Usage: python modbus_write_acuviml_v4.py <address> <value>"}))
        sys.exit(1)

    address = int(sys.argv[1])
    value = int(sys.argv[2]) if address in INT_ADDRESSES else float(sys.argv[2])

    result = write_register(address, value)
    print(json.dumps(result))
