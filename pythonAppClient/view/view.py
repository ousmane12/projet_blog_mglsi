import tkinter as tk
from tkinter import ttk
from tkinter.messagebox import showinfo
from pythonAppClient.model.model import LoginModel, UserModel


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

        self.treeFrame = tk.Frame(self.win, width=self.width - self.width/3-10, height=self.height - 52, bg='#2a5a84')
        self.manageFrame = tk.Frame(self.win, width=self.width / 3, height=self.height - 52, bg='#2a5a84')
        self.treeFrame.place(x=0, y=50)
        self.manageFrame.place(x=self.width - self.width/3-5, y=50)

        self.entries = {}
        self.buttons = {}
        self.labels = {}
        self.frames = {}
        self.RadioButton = {}
        self.radioVar = tk.IntVar()
        self.userController = userController

        # creer un tree pour afficher la list des utilisateur
        self.tree = ttk.Treeview(self.treeFrame, show='headings')

        self.create_view()

    def create_view(self):
        # self.create_notebook()
        mainLab = ttk.Label(self.win, text='Gestion des Utilisateur', font=('Arial', 25),
                           background="#28527a", foreground='white')
        mainLab.grid(row=0, column=0, padx=400, pady=5)

        self.draw_manageFrame()
        self.draw_treeView()

    def draw_manageFrame(self):
        self.create_search_frame(x=5,y=10)
        self.create_entry(
            self.manageFrame, "ID", x=5, y=110, textvar=tk.StringVar(), state='disabled'
        )
        self.create_entry(
            self.manageFrame, "Nom", x=5, y=150, textvar=tk.StringVar(), state='enabled'
        )
        self.create_entry(
            self.manageFrame, "Prenom", x=5, y=190, textvar=tk.StringVar(), state='enabled'
        )
        self.create_entry(
            self.manageFrame, "Mail", x=5, y=230, textvar=tk.StringVar(), state='enabled'
        )
        self.create_entry(
            self.manageFrame, "Role", x=5, y=270, textvar=tk.StringVar(), state='enabled'
        )
        self.create_entry(
            self.manageFrame, "Username", x=5, y=310, textvar=tk.StringVar(), state='enabled'
        )
        self.create_entry(
            self.manageFrame, "Password", x=5, y=350, textvar=tk.StringVar(), state='enabled'
        )
        self.create_button(self.manageFrame, name='AJOUTER', x=270, y=180, command=self.add)
        self.create_button(self.manageFrame, name='MODIFIER', x=270, y=240, command=self.update)
        self.create_button(self.manageFrame, name='SUPPRIMER', x=270, y=300, command=self.delete)

    def draw_treeView(self):
        # delete all previous rows in treeview
        # for row in self.tree.get_children():
        #     self.tree.delete(row)

        users = self.userController.getUsers()
        user = users[0].__dict__
        columns = ()
        # definition des identificateurs
        for col in user.keys():
            columns += (col,)
        self.tree = ttk.Treeview(self.treeFrame, columns=columns, show='headings')
        for col in user.keys():
            self.tree.heading(col, text=col[1:])
        # definir la taille des columns
        self.tree.column('_id', minwidth=0, width=25)
        self.tree.column('_nom', minwidth=0, width=100)
        self.tree.column('_prenom', minwidth=0, width=150)
        self.tree.column('_mail', minwidth=0, width=150)
        self.tree.column('_role', minwidth=0, width=50)
        self.tree.column('_username', minwidth=0, width=150)
        self.tree.column('_password', minwidth=0, width=160)

        # generate tuple of users
        usrs = []
        for user in users:
            dic = user.__dict__
            usrs.append(
                (f'{dic["_id"]}', f'{dic["_nom"]}', f'{dic["_prenom"]}', f'{dic["_mail"]}',
                 f'{dic["_role"]}', f'{dic["_username"]}', f'{dic["_password"]}'))

        for user in usrs:
            self.tree.insert('', tk.END, values=user)
        self.tree.place(x=0, y=0)
        self.tree.bind("<<TreeviewSelect>>", self.on_tree_select)

    # bind the select event
    def on_tree_select(self, event):
        item = self.tree.selection()[0]
        id = self.tree.item(item, 'values')[0]
        nom = self.tree.item(item, 'values')[1]
        prenom = self.tree.item(item, 'values')[2]
        mail = self.tree.item(item, 'values')[3]
        role = self.tree.item(item, 'values')[4]
        username = self.tree.item(item, 'values')[5]
        password = self.tree.item(item, 'values')[6]
        user = UserModel(id=id, nom=nom, prenom=prenom,mail=mail,role=role, username=username,password=password)
        self.set_entries(user)

    def set_entries(self, user):
        # vider les zones de saisie
        self.clear_entries()
        self.entries['ID'].configure(state='normal')
        self.entries['ID'].insert(0, user.getId())
        self.entries['ID'].configure(state='disabled')
        self.entries['Nom'].insert(0, user.getNom())
        self.entries['Prenom'].insert(0, user.getPrenom())
        self.entries['Mail'].insert(0, user.getMail())
        self.entries['Role'].insert(0, user.getRole())
        self.entries['Username'].insert(0, user.getUsername())
        self.entries['Password'].insert(0, user.getPassword())

    # fonction vider toutes les zones de saisie
    def clear_entries(self):
        self.entries['ID'].configure(state='normal')
        self.entries['ID'].delete(0, tk.END)
        self.entries['ID'].configure(state='disabled')
        self.entries['Nom'].delete(0, tk.END)
        self.entries['Prenom'].delete(0, tk.END)
        self.entries['Mail'].delete(0, tk.END)
        self.entries['Role'].delete(0, tk.END)
        self.entries['Username'].delete(0, tk.END)
        self.entries['Password'].delete(0, tk.END)

    # Creer une zone de saisie
    def create_entry(self, frame, label, x, y, textvar, state):
        self.labels[label] = tk.Label(frame, text=label, bg="#2a5a84", fg='white', font=("Calibri 12"))
        self.labels[label].place(x=x, y=y)
        self.labels[label].update()
        self.entries[label] = ttk.Entry(frame, width=20, textvariable=textvar, state=state, font=("Calibri 12"))
        self.entries[label].place(x=x + 70, y=y)

    def create_search_frame(self, x, y):
        searchFrame = tk.Frame(self.manageFrame, width=self.width / 3, height=80, bg='#2a5a84')
        searchFrame.place(x=0, y=5)

        self.entries['search'] = ttk.Entry(searchFrame, width=25,  font=("Arial 12"))
        self.entries['search'].place(x= 40, y= 20)

        self.RadioButton['id'] = tk.Radiobutton(searchFrame, text='Id', bg="#2a5a84",
                                                fg="black", variable=self.radioVar, value=1)
        self.RadioButton['mail'] = tk.Radiobutton(searchFrame, text='Mail', bg="#2a5a84",
                                                  fg="black", variable=self.radioVar, value=2)
        # selectionee le bouton mail par defaut
        self.RadioButton['mail'].select()

        self.RadioButton['id'].place(x=150, y=50)
        self.RadioButton['mail'].place(x=100, y=50)

        self.buttons['search'] = tk.Button(searchFrame, width=5, height=1, bg='#21486b', fg='white', command=self.search)
        self.buttons['search']["text"] = 'Search'
        self.buttons['search'].place(x= 280, y=20)

    def search(self):
        radio = self.radioVar.get()
        search_input= self.entries['search'].get()
        self.userController.searchUser(radio, search_input)

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
        role = self.entries['Role'].get()
        username = self.entries['Username'].get()
        password = self.entries['Password'].get()
        userModel = UserModel(id, nom, prenom, mail, role, username, password)
        return userModel

    # appeler la fontion addUser de userManagerController
    def add(self):
        response = self.userController.addUser(self.getUserInput())


    def delete(self):
        self.userController.deleteUser(self.getUserInput().getId())

    def update(self):
        self.userController.updateUser(self.getUserInput())

    # Launch the window
    def main(self):
        self.win.mainloop()
