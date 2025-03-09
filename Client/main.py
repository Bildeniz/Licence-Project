import tkinter as tk
from tkinter import messagebox
from business import check_licence_key
from threading import Thread

def check_btn():
    check_button.config(state="disabled")

    check_licence_key(entry.get())

    check_button.config(state="normal")

root = tk.Tk()
root.title("Licence Auth")
root.geometry("400x200")
root.resizable(False, False)

bg_color = "#f0f0f0"
font_style = ("Arial", 12)

root.configure(bg=bg_color)

label = tk.Label(root, text="Licence Key:", font=font_style, bg=bg_color)
label.pack(pady=10)

entry = tk.Entry(root, width=30, font=font_style, bd=2, relief="groove")
entry.pack(pady=10)

check_button = tk.Button(
    root,
    text="Check",
    font=font_style,
    bg="#4CAF50",
    fg="white",
    activebackground="#45a049",
    activeforeground="white",
    command=lambda: Thread(check_btn()).start(),
    bd=2,
    relief="raised"
)
check_button.pack(pady=20)

entry.bind("<Return>", lambda: Thread(check_btn()).start())

root.mainloop()