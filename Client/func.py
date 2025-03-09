import requests
import platform
import hashlib
import subprocess
import uuid

url = "http://localhost/"

def check_licence(licence:str) -> dict:
    res = requests.post(url + "api/licence_auth.php",
                  json={
                      "licence":licence,
                      "fingerprint": get_system_fingerprint()
                  })

    return res.json()

def get_system_fingerprint()->str:
    system_info = {
        "mac_address": ':'.join(
            ['{:02x}'.format((uuid.getnode() >> elements) & 0xff) for elements in range(0, 2 * 6, 2)][::-1]),
        "processor": platform.processor(),
        "machine": platform.machine(),
        "platform": platform.platform(),
        "system": platform.system(),
        "node": platform.node(),
    }

    if platform.system() == "Windows":
        try:
            disk_serial = \
            subprocess.check_output("wmic diskdrive get serialnumber", shell=True).decode().split("\n")[1].strip()
            system_info["disk_serial"] = disk_serial
        except:
            system_info["disk_serial"] = "unknown"
    else:
        system_info["disk_serial"] = "unknown"

    fingerprint_str = ''.join([f"{key}:{value}" for key, value in system_info.items()])
    fingerprint_hash = hashlib.sha256(fingerprint_str.encode()).hexdigest()

    return fingerprint_hash
