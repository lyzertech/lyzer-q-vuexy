# modbus_write.py
import sys
import json
from pymodbus.client.sync import ModbusSerialClient
from pymodbus.payload import BinaryPayloadBuilder
from pymodbus.constants import Endian

def write_float(address, value):
    client = ModbusSerialClient(
        method='rtu',
        port='COM3',
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
        builder.add_32bit_float(value)
        payload = builder.to_registers()

        response = client.write_registers(address, payload, unit=1)
        client.close()

        if response.isError():
            return {"status": "error", "message": str(response)}
        else:
            return {"status": "ok", "written": value, "address": address}

    return {"status": "error", "message": "Cannot connect to device"}


if __name__ == "__main__":
    if len(sys.argv) != 3:
        print(json.dumps({"status": "error", "message": "Usage: python modbus_write.py <address> <value>"}))
        sys.exit(1)

    address = int(sys.argv[1])
    value = float(sys.argv[2])

    result = write_float(address, value)
    print(json.dumps(result))
