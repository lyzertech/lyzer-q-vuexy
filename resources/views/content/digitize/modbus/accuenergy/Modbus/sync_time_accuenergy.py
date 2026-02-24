# sync_time_accuenergy.py
# Device : Accuenergy AcuDC240
# Standalone script — syncs PC local time to AcuDC240 via Modbus RTU
# COM4 / 9600 baud / unit 1 / registers 644-649 (Year, Month, Day, Hour, Minute, Second)
#
# Usage:
#   python sync_time_accuenergy.py
#   OR just double-click SyncTime_AcuDC240.bat
#
# No arguments needed. Just run it directly.

from pymodbus.client.sync import ModbusSerialClient
from pymodbus.payload import BinaryPayloadBuilder
from pymodbus.constants import Endian
from datetime import datetime

# ---------------------------------------------------------------------------
# Config
# ---------------------------------------------------------------------------
PORT     = 'COM4'
BAUDRATE = 9600
UNIT_ID  = 1

# Date/Time registers (16-bit unsigned integer each)
REGISTERS = {
    644: 'Year',
    645: 'Month',
    646: 'Day',
    647: 'Hour',
    648: 'Minute',
    649: 'Second',
}


def write_uint16(client, address, value):
    builder = BinaryPayloadBuilder(byteorder=Endian.Big, wordorder=Endian.Big)
    builder.add_16bit_uint(int(value))
    payload = builder.to_registers()
    response = client.write_registers(address, payload, unit=UNIT_ID)
    return not response.isError()


def sync_time():
    now = datetime.now()  # local PC time

    values = {
        644: now.year,
        645: now.month,
        646: now.day,
        647: now.hour,
        648: now.minute,
        649: now.second,
    }

    print(f"PC time      : {now.strftime('%Y-%m-%d %H:%M:%S')}")
    print(f"Connecting to: {PORT} @ {BAUDRATE} baud, unit {UNIT_ID}")
    print()

    client = ModbusSerialClient(
        method='rtu',
        port=PORT,
        baudrate=BAUDRATE,
        bytesize=8,
        parity='N',
        stopbits=1,
        timeout=1
    )

    if not client.connect():
        print(f"ERROR: Cannot connect to device on {PORT}")
        return

    success = 0
    fail    = 0

    for addr, name in REGISTERS.items():
        val = values[addr]
        ok  = write_uint16(client, addr, val)
        status = "OK" if ok else "FAIL"
        print(f"  [{status}] Reg {addr} ({name:6s}) = {val}")
        if ok:
            success += 1
        else:
            fail += 1

    client.close()

    print()
    if fail == 0:
        print(f"Done — all {success} registers written successfully.")
    else:
        print(f"Done — {success} OK, {fail} FAILED. Check device connection.")


if __name__ == '__main__':
    sync_time()
