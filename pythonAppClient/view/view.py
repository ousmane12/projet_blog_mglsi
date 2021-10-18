import tkinter as tk
from tkinter import ttk
from tkinter.messagebox import showinfo
from pythonAppClient.model.model import LoginModel, UserModel


################## CLASS VIEW ##################
class View:
    pass


################## CLASS LOGIN VIEW ##################
class LogView:
    def __init__(self, logController):
        self.win = tk.Tk()
        self.win.title('BLOG MGLSI ADMIN 1.0')
        self.entries = {}
        self.buttons = {}
        self.labels = {}
        self.logController = logController

        self.create_view()

    def create_view(self):
        control_frame = tk.Frame(self.win)
        control_frame.rowconfigure(0, weight=1)
        control_frame.columnconfigure(0, weight=1)
        control_frame.grid(row=1, column=0, sticky=tk.N + tk.S + tk.E + tk.W, padx=5, pady=5)

        self.create_label(control_frame, text='Authentification', row=0, column=0)
        self.create_entry(
            control_frame, "Login", row=1, column=0, textvar=tk.DoubleVar()
        )
        self.create_entry_passwd(
            control_frame, "Password", row=2, column=0, textvar=tk.DoubleVar()
        )

        self.create_button(control_frame, "Login", row=3, column=0, command=self.getLoginModel)

    # Creer une zone de text et son label
    def create_entry(self, frame, label, row, column, textvar):
        label_frame = tk.LabelFrame(frame, text=label)
        self.entries[label] = tk.Entry(label_frame, textvariable=textvar, width=50)
        self.entries[label].grid(row=1, column=1, padx=5, pady=5)
        self.entries[label].delete(0, 3)
        label_frame.grid(row=row, column=column, sticky=tk.N + tk.S + tk.E + tk.W, padx=5, pady=5)

    def create_entry_passwd(self, frame, label, row, column, textvar):
        label_frame = tk.LabelFrame(frame, text=label)
        self.entries[label] = tk.Entry(label_frame, textvariable=textvar, width=50, show='*')
        self.entries[label].grid(row=1, column=1, padx=5, pady=5)
        self.entries[label].delete(0, 3)
        label_frame.grid(row=row, column=column, sticky=tk.N + tk.S + tk.E + tk.W, padx=5, pady=5)

    # creer un bouton
    def create_button(self, frame, name, row, column, command):
        self.buttons[name] = tk.Button(frame, width=10, command=command)
        self.buttons[name]["text"] = name
        self.buttons[name].grid(row=row, column=column, pady=3)

    # creer un label
    def create_label(self, frame, text, row, column):
        self.labels[text] = tk.Label(frame, text=text)
        self.labels[text].grid(row=row, column=column)

    # recuperer les donnees lorqu'on appui sur le button login
    def getLoginModel(self):
        login = self.entries['Login'].get()
        passwd = self.entries['Password'].get()
        logModel = LoginModel(login, passwd)

        # appeler la fontion login du controlleur
        self.logController.login(logModel)

    def quit(self):
        self.win.destroy()

    # Launch the window
    def main(self):
        self.win.mainloop()


################## CLASS USER MANAGER VIEW ##################
class UserView:

    def __init__(self, userController):
        self.win = tk.Tk()
        self.win.title('BLOG MGLSI ADMIN BOARD 1.0')
        self.width = 1080
        self.height = 650
        self.win.geometry(f'{self.width}x{self.height}')
        self.win.resizable(False, False)
        self.win.config(background='#28527a')

        self.treeFrame = tk.Frame(self.win, width=self.width / 2 - 5, height=self.height - 52, bg='#2a5a84')
        self.manageFrame = tk.Frame(self.win, width=self.width / 2 - 5, height=self.height - 52, bg='#2a5a84')
        self.treeFrame.place(x=0, y=50)
        self.manageFrame.place(x=self.width / 2, y=50)

        self.entries = {}
        self.buttons = {}
        self.labels = {}
        self.frames = {}
        self.userController = userController

        # creer un tree pour afficher la list des utilisateur
        columns = ('#1', '#2', '#3', '#4', '#5')
        self.tree = ttk.Treeview(self.treeFrame, columns=columns, show='headings')

        self.create_view()

    def create_view(self):
        # self.create_notebook()
        addLab = ttk.Label(self.win, text='Gestion des Utilisateur', font=('Arial', 25),
                           background="#28527a", foreground='white')
        addLab.grid(row=0, column=0, padx=400, pady=5)

        self.draw_manageFrame()
        self.draw_treeView()

    def draw_manageFrame(self):
        self.create_entry(
            self.manageFrame, "ID", x=40, y=110, textvar=tk.DoubleVar(), state='disabled'
        )

        self.create_entry(
            self.manageFrame, "Nom", x=40, y=150, textvar=tk.DoubleVar(), state='enabled'
        )
        self.create_entry(
            self.manageFrame, "Prenom", x=40, y=190, textvar=tk.DoubleVar(), state='enabled'
        )
        self.create_entry(
            self.manageFrame, "Mail", x=40, y=230, textvar=tk.DoubleVar(), state='enabled'
        )
        self.create_entry(
            self.manageFrame, "Statut", x=40, y=270, textvar=tk.DoubleVar(), state='enabled'
        )
        self.create_button(self.manageFrame, name='AJOUTER', x=430, y=120, command=self.add)
        self.create_button(self.manageFrame, name='MODIFIER', x=430, y=180, command=self.update)
        self.create_button(self.manageFrame, name='SUPPRIMER', x=430, y=240, command=self.delete)

    def draw_treeView(self):
        users = self.userController.getUsers()

        # definition des identificateurs
        columns = ('#1', '#2', '#3', '#4', '#5')
        self.tree = ttk.Treeview(self.treeFrame, columns=columns, show='headings')
        self.tree.heading('#1', text='ID')
        self.tree.column("#1", minwidth=0, width=25)
        self.tree.heading('#2', text='Nom')
        self.tree.column("#2", minwidth=0, width=100)
        self.tree.heading('#3', text='Prenom')
        self.tree.column("#3", minwidth=0, width=160)
        self.tree.heading('#4', text='Mail')
        self.tree.column("#4", minwidth=0, width=170)
        self.tree.heading('#5', text='Statut')
        self.tree.column("#5", minwidth=0, width=100)

        # generate tuple of users
        usrs = []
        for user in users:
            dic = user.__dict__
            usrs.append(
                (f'{dic["_id"]}', f'{dic["_nom"]}', f'{dic["_prenom"]}', f'{dic["_mail"]}', f'{dic["_statut"]}'))

        for user in usrs:
            self.tree.insert('', tk.END, values=user)
        self.tree.place(x=0, y=0)
        self.tree.bind("<<TreeviewSelect>>", self.on_tree_select)

    # bind the select event
    def on_tree_select(self, event):
        print("selected items:")
        item = self.tree.selection()[0]
        self.set_entries(item)

    def set_entries(self,item):

        self.entries['ID'].configure(state='normal')
        self.entries['ID'].delete(0, tk.END)
        self.entries['ID'].insert(0, self.tree.item(item, 'values')[0])
        self.entries['ID'].configure(state='disabled')
        self.entries['Nom'].delete(0, tk.END)
        self.entries['Nom'].insert(0, self.tree.item(item, 'values')[1])
        self.entries['Prenom'].delete(0, tk.END)
        self.entries['Prenom'].insert(0, self.tree.item(item, 'values')[2])
        self.entries['Mail'].delete(0, tk.END)
        self.entries['Mail'].insert(0, self.tree.item(item, 'values')[3])
        self.entries['Statut'].delete(0, tk.END)
        self.entries['Statut'].insert(0, self.tree.item(item, 'values')[4])


    # Creer une zone de saisie
    def create_entry(self, frame, label, x, y, textvar, state):
        self.labels[label] = tk.Label(frame, text=label, bg="#2a5a84", fg='white', font=("Calibri 14"))
        self.labels[label].place(x=x, y=y)
        self.labels[label].update()
        self.entries[label] = ttk.Entry(frame, width=25, textvariable=textvar, state=state, font=("Calibri 16"))
        self.entries[label].place(x=x + 70, y=y)
        self.entries[label].delete(0, 3)

    def quit(self):
        self.win.destroy()

    # creer un bouton
    def create_button(self, frame, name, x, y, command):
        self.buttons[name] = tk.Button(frame, width=10, height=2, bg='#21486b', fg='white', command=command)
        self.buttons[name]["text"] = name
        self.buttons[name].place(x=x, y=y)

    # creer un label
    def create_label(self, frame, text, x, y):
        self.labels[text] = tk.Label(frame, text=text)
        self.labels[text].place(x=x, y=y)

    # recuperer les donnees saisie
    def getUserInput(self):
        id = self.entries['ID'].get()
        nom = self.entries['Nom'].get()
        prenom = self.entries['Prenom'].get()
        mail = self.entries['Mail'].get()
        statut = self.entries['Statut'].get()
        userModel = UserModel(id, nom, prenom, mail, statut)
        # print(f"Login: {self.logModel.getLogin()}")
        # print(f"Passwd: {self.logModel.getPassword()}")
        return userModel

    # appeler la fontion addUser de userManagerController
    def add(self):
        self.userController.addUser(self.getUserInput())

    def delete(self):
        self.userController.deleteUser(self.getUserInput())

    def update(self):
        self.userController.updateUser(self.getUserInput())

    # Launch the window
    def main(self):
        self.win.mainloop()
