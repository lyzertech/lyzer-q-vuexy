from pymodbus.client.sync import ModbusSerialClient
from pymodbus.payload import BinaryPayloadDecoder
from pymodbus.constants import Endian
import json, sys


IO_MAP = {
    1: "Voltage",
    2: "Current"
}

PARAM_SELECT_MAP = {
    0:  "Volts 1",
    1:  "Volts 2",
    2:  "Volts 3",
    3:  "Current 1",
    4:  "Current 2",
    5:  "Current 3",
    6:  "Watt 1",
    7:  "Watt 2",
    8:  "Watt 3",
    9:  "VA 1",
    10: "VA 2",
    11: "VA 3",
    12: "VAr 1",
    13: "VAr 2",
    14: "VAr 3",
    15: "PF 1",
    16: "PF 2",
    17: "PF 3",
    18: "PA 1",
    19: "PA 2",
    20: "PA 3",
    21: "Volts Average",
    23: "Current Average",
    26: "Watts sum",
    28: "VA sum",
    30: "VAr sum",
    31: "PF Average",
    33: "PA Average",
    35: "Frequency",
    84: "Re-Active PF L1",
    85: "Re-Active PF L2",
    86: "Re-Active PF L3",
    87: "Avg Re-Active PF",
    89: "LF SgnQ(1-(P/S)) L1",
    90: "LF SgnQ(1-(P/S)) L2",
    91: "LF SgnQ(1-(P/S)) L3",
    92: "Avg LF SgnQ(1-(P/S))",
    100: "V1-2",
    101: "V2-3",
    102: "V3-1",

    127: "Distortion VAr L1",
    128: "Distortion VAr L2",
    129: "Distortion VAr L3",
    131: "SUM Distortion VAr",

    150: "Sys kW Import Demand",
    151: "Sys kW Export Demand",
    152: "Sys kVAr Import Demand",
    153: "Sys kVAr Export Demand",
    154: "Sys kVA Demand",
    156: "Sys Current Demand",

    158: "Sys kW Import Max Demand",
    159: "Sys kW Export Max Demand",
    160: "Sys kVAr Import Max Demand",
    161: "Sys kVAr Export Max Demand",
    162: "Sys kVA Max Demand",
    164: "Sys Current Max Demand",

    167: "kW Import Demand L1",
    168: "kW Import Demand L2",
    169: "kW Import Demand L3",

    170: "kW Export Demand L1",
    171: "kW Export Demand L2",
    172: "kW Export Demand L3",

    173: "kVAr Import Demand L1",
    174: "kVAr Import Demand L2",
    175: "kVAr Import Demand L3",

    176: "kVAr Export Demand L1",
    177: "kVAr Export Demand L2",
    178: "kVAr Export Demand L3",

    179: "kVA Demand L1",
    180: "kVA Demand L2",
    181: "kVA Demand L3",

    184: "Current Demand L1",
    185: "Current Demand L2",
    186: "Current Demand L3",

    190: "kW Import Max Demand L1",
    191: "kW Import Max Demand L2",
    192: "kW Import Max Demand L3",

    193: "kW Export Max Demand L1",
    194: "kW Export Max Demand L2",
    195: "kW Export Max Demand L3",

    196: "kVAr Import Max Demand L1",
    197: "kVAr Import Max Demand L2",
    198: "kVAr Import Max Demand L3",

    199: "kVAr Export Max Demand L1",
    200: "kVAr Export Max Demand L2",
    201: "kVAr Export Max Demand L3",

    202: "kVA Max Demand L1",
    203: "kVA Max Demand L2",
    204: "kVA Max Demand L3",

    208: "Current Max Demand L1",
    209: "Current Max Demand L2",
    210: "Current Max Demand L3",
}

MAP = {
    6002: "System Type",
    6004: "VT Primary",
    6006: "CT Primary",
    6012: "System Freq.",
    6008: "VT Secondary",
    6010: "CT Secondary",

    6248: "AO1 type (1:V 2:A)",
    6254: "Input Start",
    6260: "Output Start",
    6250: "Parameter Select",
    6258: "Input End",
    6264: "Output End",

    6266: "AO2 type (1:V 2:A)",
    6272: "Input Start",
    6278: "Output Start",
    6268: "Parameter Select",
    6276: "Input End",
    6282: "Output End",

    6284: "AO3 type (1:V 2:A)",
    6290: "Input Start",
    6296: "Output Start",
    6286: "Parameter Select",
    6294: "Input End",
    6300: "Output End",

    6302: "AO4 type (1:V 2:A)",
    6308: "Input Start",
    6314: "Output Start",
    6304: "Parameter Select",
    6312: "Input End",
    6318: "Output End",


    0: "Voltage L1",
    2: "Voltage L2",
    4: "Voltage L3",
    6: "Current L1",
    8: "Current L2",
    10: "Current L3",
    12: "Watt L1",
    14: "Watt L2",
    16: "Watt L3",
    18: "VA L1",
    20: "VA L2",
    22: "VA L3",
    24: "VAr L1",
    26: "VAr L2",
    28: "VAr L3",
    30: "PF L1",
    32: "PF L2",
    34: "PF L3",
    36: "PA L1",
    38: "PA L2",
    40: "PA L3",
    42: "Voltage Avg",
    44: "Voltage Sum",
    46: "Current Avg",
    48: "Current Sum",
    50: "Watt Avg",
    52: "Watt Sum",
    54: "VA Avg",
    56: "VA Sum",
    58: "VAr Avg",
    60: "VAr Sum",
    62: "PF Avg",
    64: "PF Sum",
    66: "PA Avg",
    68: "PA Sum",
    70: "Frequency",
    200: "Voltage L12",
    202: "Voltage L23",
    204: "Voltage L31",
}

SPECIAL_VALUE_MAP = {
    6002: {
        1: "1P2W",
        2: "3P3W Unbal",
        3: "3P4W Unbal",
        4: "U31 I1 Bal",
        5: "U23 I1 Bal",
        6: "U12 I1 Bal",
        7: "3P3W Bal",
        8: "3P4W Bal",
    },
    6248: IO_MAP,
    6266: IO_MAP,
    6284: IO_MAP,
    6302: IO_MAP,
    6250: PARAM_SELECT_MAP,
    6268: PARAM_SELECT_MAP,
    6286: PARAM_SELECT_MAP,
    6304: PARAM_SELECT_MAP,
}

def read_float(registers, start_addr, target_addr):
    """Decode 32-bit float from registers based on Modbus address."""
    index = target_addr - start_addr
    if index < 0 or index + 1 >= len(registers):
        return None

    reg_slice = registers[index:index+2]

    try:
        dec = BinaryPayloadDecoder.fromRegisters(
            reg_slice,
            byteorder=Endian.Big,
            wordorder=Endian.Big
        )
        return dec.decode_32bit_float()
    except:
        return None


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

    result = {}

    if client.connect():
        rr = client.read_holding_registers(address, count, unit=1)

        if not rr.isError():
            registers = rr.registers

            for target_addr, title in MAP.items():
                if address <= target_addr < address + count:

                    # SPECIAL: System Type must decode as float → int → mapped label
                    if target_addr in SPECIAL_VALUE_MAP:
                        fval = read_float(registers, address, target_addr)
                        if fval is not None:
                            intval = int(round(fval))
                            value = SPECIAL_VALUE_MAP[target_addr].get(intval, intval)
                        else:
                            value = None

                    else:
                        # Normal float value
                        fval = read_float(registers, address, target_addr)
                        value = round(fval, 2) if fval is not None else None

                    result[title] = {
                        "value": value,
                        "address": target_addr
                    }

        client.close()

    return result


if __name__ == "__main__":
    if len(sys.argv) != 3:
        print(json.dumps({"error": "Usage: python modbus_read.py <address> <count>"}))
        sys.exit(1)

    address = int(sys.argv[1])
    count = int(sys.argv[2])

    print(json.dumps(read_modbus(address, count), indent=2))
