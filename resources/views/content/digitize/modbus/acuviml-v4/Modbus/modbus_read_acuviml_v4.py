# modbus_read_acuviml_v4.py
# Device : Accuenergy Acuvim L-V4
# Modbus RTU — COM4 / 19200 baud / unit 1
# Usage  : python modbus_read_acuviml_v4.py <address> <count>

from pymodbus.client.sync import ModbusSerialClient
from pymodbus.payload import BinaryPayloadDecoder
from pymodbus.constants import Endian
import json
import sys

# ---------------------------------------------------------------------------
# INT_MAP  : address → label  for 16-bit INTEGER registers (1 register each)
# FLOAT_MAP: address → label  for 32-bit FLOAT registers   (2 registers each)
# Populate these from the Acuvim L-V4 register datasheet.
# ---------------------------------------------------------------------------
INT_MAP = {
    4159: "Week",
    4160: "Year",
    4161: "Month",
    4162: "Day",
    4163: "Hour",
    4164: "Minute",
    4165: "Second",
}

FLOAT_MAP = {
    # Add 32-bit float registers here, e.g.:
    # 0: "Voltage L1",
    # 2: "Voltage L2",
}

# Convenience set for quick look-up
INT_ADDRESSES = set(INT_MAP.keys())

# ---------------------------------------------------------------------------
# Special value maps (address → {int_code: label}) for labelled integers
# ---------------------------------------------------------------------------
SPECIAL_VALUE_MAP = {
    # Example: 100: {1: "3P4W", 2: "3P3W", ...}
}


def read_int(registers, start_addr, target_addr):
    """Decode a 16-bit unsigned integer from a single register."""
    index = target_addr - start_addr
    if index < 0 or index >= len(registers):
        return None
    try:
        dec = BinaryPayloadDecoder.fromRegisters(
            [registers[index]],
            byteorder=Endian.Big,
            wordorder=Endian.Big
        )
        return dec.decode_16bit_uint()
    except Exception:
        return None


def read_float(registers, start_addr, target_addr):
    """Decode a 32-bit float from two consecutive registers."""
    index = target_addr - start_addr
    if index < 0 or index + 1 >= len(registers):
        return None
    reg_slice = registers[index:index + 2]
    try:
        dec = BinaryPayloadDecoder.fromRegisters(
            reg_slice,
            byteorder=Endian.Big,
            wordorder=Endian.Big
        )
        return dec.decode_32bit_float()
    except Exception:
        return None


def read_modbus(address, count):
    client = ModbusSerialClient(
        method='rtu',
        port='COM4',
        baudrate=19200,
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

            all_entries = list(INT_MAP.items()) + list(FLOAT_MAP.items())

            for target_addr, title in all_entries:
                if address <= target_addr < address + count:

                    if target_addr in INT_ADDRESSES:
                        raw = read_int(registers, address, target_addr)
                        if raw is not None and target_addr in SPECIAL_VALUE_MAP:
                            value = SPECIAL_VALUE_MAP[target_addr].get(raw, raw)
                        else:
                            value = raw
                    elif target_addr in SPECIAL_VALUE_MAP:
                        fval = read_float(registers, address, target_addr)
                        if fval is not None:
                            intval = int(round(fval))
                            value = SPECIAL_VALUE_MAP[target_addr].get(intval, intval)
                        else:
                            value = None
                    else:
                        fval = read_float(registers, address, target_addr)
                        value = round(fval, 2) if fval is not None else None

                    result[title] = {
                        "value": value,
                        "address": target_addr
                    }
        else:
            result["__error"] = {
                "message": "Modbus read error",
                "raw": str(rr)
            }

        client.close()
    else:
        result["__error"] = {
            "message": "Cannot connect to device on COM4"
        }

    return result


if __name__ == "__main__":
    if len(sys.argv) != 3:
        print(json.dumps({"error": "Usage: python modbus_read_acuviml_v4.py <address> <count>"}))
        sys.exit(1)

    address = int(sys.argv[1])
    count = int(sys.argv[2])

    print(json.dumps(read_modbus(address, count), indent=2))
