# modbus_read.py
from pymodbus.client.sync import ModbusTcpClient
from pymodbus.payload import BinaryPayloadDecoder
from pymodbus.constants import Endian
import json

def read_modbus():
    client = ModbusTcpClient("192.168.2.113", port=502)
    data = {}

    if client.connect():
        rr = client.read_holding_registers(16384, 100, unit=1)  # read enough regs
        if not rr.isError():
            decoder = BinaryPayloadDecoder.fromRegisters(
                rr.registers,
                byteorder=Endian.Big,
                wordorder=Endian.Big
            )

            data = {
                "Freq_Hz": round(decoder.decode_32bit_float(), 2),
                "V1": round(decoder.decode_32bit_float(), 2),
                "V2": round(decoder.decode_32bit_float(), 2),
                "V3": round(decoder.decode_32bit_float(), 2),
                "Vnavg_V": round(decoder.decode_32bit_float(), 2),
                "V12": round(decoder.decode_32bit_float(), 2),
                "V23": round(decoder.decode_32bit_float(), 2),
                "V31": round(decoder.decode_32bit_float(), 2),
                "VIavg_V": round(decoder.decode_32bit_float(), 2),
                "I1": round(decoder.decode_32bit_float(), 2),
                "I2": round(decoder.decode_32bit_float(), 2),
                "I3": round(decoder.decode_32bit_float(), 2),
                "Iavg_A": round(decoder.decode_32bit_float(), 2),
                "In": round(decoder.decode_32bit_float(), 2),
                "P1": round(decoder.decode_32bit_float(), 2),
                "P2": round(decoder.decode_32bit_float(), 2),
                "P3": round(decoder.decode_32bit_float(), 2),
                "Psum_kW": round(decoder.decode_32bit_float(), 2),
                "Q1": round(decoder.decode_32bit_float(), 2),
                "Q2": round(decoder.decode_32bit_float(), 2),
                "Q3": round(decoder.decode_32bit_float(), 2),
                "Qsum_kvar": round(decoder.decode_32bit_float(), 2),
                "S1": round(decoder.decode_32bit_float(), 2),
                "S2": round(decoder.decode_32bit_float(), 2),
                "S3": round(decoder.decode_32bit_float(), 2),
                "Ssum_kVA": round(decoder.decode_32bit_float(), 2),
                "PF1": round(decoder.decode_32bit_float(), 2),
                "PF2": round(decoder.decode_32bit_float(), 2),
                "PF3": round(decoder.decode_32bit_float(), 2),
                "PF": round(decoder.decode_32bit_float(), 2),
            }
        client.close()

    return data


if __name__ == "__main__":
    result = read_modbus()
    print(json.dumps(result, indent=2))
