from func import *
from tkinter import messagebox

def check_licence_key(licence:str)->None:
    res = check_licence(licence)

    if res['auth']:
        messagebox.showinfo("Licence Auth", "Your licence has been accepted")
    else:
        messagebox.showerror("Licence Auth", "Your licence has been rejected")