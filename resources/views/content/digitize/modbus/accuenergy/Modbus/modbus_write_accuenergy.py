# modbus_write_accuenergy.py
# Device : Accuenergy AcuDC240
# Modbus RTU — COM4 / 9600 baud / unit 1
# Usage  : python modbus_write_accuenergy.py <address> <value>

import sys
import json
from pymodbus.client.sync import ModbusSerialClient
from pymodbus.payload import BinaryPayloadBuilder
from pymodbus.constants import Endian

# Addresses that store 16-bit integers (1 register each)
# Keep in sync with modbus_read_accuenergy.py INT_MAP
INT_ADDRESSES = {644, 645, 646, 647, 648, 649}


def write_register(address, value):
    client = ModbusSerialClient(
        method='rtu',
        port='COM4',
        baudrate=9600,
        bytesize=8,
        parity='N',
        stopbits=1,
        timeout=1
    )

    if client.connect():
        builder = BinaryPayloadBuilder(
            byteorder=Endian.Big,
            wordorder=Endian.Big
        )
        if address in INT_ADDRESSES:
            builder.add_16bit_uint(int(value))
        else:
            builder.add_32bit_float(float(value))
        payload = builder.to_registers()

        response = client.write_registers(address, payload, unit=1)
        client.close()

        if response.isError():
            return {"status": "error", "message": str(response)}
        else:
            return {"status": "ok", "written": value, "address": address}

    return {"status": "error", "message": "Cannot connect to device on COM4"}


if __name__ == "__main__":
    if len(sys.argv) != 3:
        print(json.dumps({"status": "error", "message": "Usage: python modbus_write_accuenergy.py <address> <value>"}))
        sys.exit(1)

    address = int(sys.argv[1])
    value = int(sys.argv[2]) if address in INT_ADDRESSES else float(sys.argv[2])

    result = write_register(address, value)
    print(json.dumps(result))
