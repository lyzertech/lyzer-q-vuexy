# modbus_read.py
from pymodbus.client.sync import ModbusSerialClient
from pymodbus.payload import BinaryPayloadDecoder
from pymodbus.constants import Endian
import json
import sys

def read_modbus(address, count):
    client = ModbusSerialClient(
        method='rtu',
        port='COM3',
        baudrate=9600,
        bytesize=8,
        parity='N',
        stopbits=1,
        timeout=1
    )

    data = {}

    if client.connect():
        rr = client.read_holding_registers(address, count, unit=1)

        if not rr.isError():
            decoder = BinaryPayloadDecoder.fromRegisters(
                rr.registers,
                byteorder=Endian.Big,
                wordorder=Endian.Big
            )

            data = {
                "System Type": {
                    "value": round(decoder.decode_32bit_float(), 2),
                    "address": 6002
                },
                "VT Primary": {
                    "value": round(decoder.decode_32bit_float(), 2),
                    "address": 6004
                },
                "CT Primary": {
                    "value": round(decoder.decode_32bit_float(), 2),
                    "address": 6006
                },
                "VT Secondary": {
                    "value": round(decoder.decode_32bit_float(), 2),
                    "address": 6008
                },
                "CT Secondary": {
                    "value": round(decoder.decode_32bit_float(), 2),
                    "address": 6010
                },
                "System Freq.": {
                    "value": round(decoder.decode_32bit_float(), 2),
                    "address": 6012
                }
            }

        client.close()

    return data


if __name__ == "__main__":
    # Need 2 params: address + count
    if len(sys.argv) != 3:
        print(json.dumps({"error": "Usage: python modbus_read.py <address> <count>"}))
        sys.exit(1)

    address = int(sys.argv[1])   # e.g. 6002
    count = int(sys.argv[2])     # e.g. 40

    result = read_modbus(address, count)
    print(json.dumps(result, indent=2))
