from tkinter import messagebox

from zeep import Client

from pythonAppClient.model.model import LoginModel, UserModel
from pythonAppClient.service.userService import UserService
from pythonAppClient.view.view import LogView, UserView


################## CLASS LOGIN CONTROLLER ##################
class LogController:
    userService = UserService()
    def __init__(self):
        self.logModel = LoginModel(login="", passwd="")
        self.logView = LogView(self)

    def main(self):
        self.logView.main()

    def login(self, logModel: LoginModel):
        auth = self.userService.authenticate(username=logModel.getLogin(), password=logModel.getPassword())
        if auth == 1:
            print('Login success')
            self.logView.quit()
            userControl = UserManagerController()
            userControl.main()
        else:
            print("login failed")
            messagebox.showinfo("Failed", "Invalid username or password ", parent=self.logView.win)

################## CLASS USER MANAGER CONTROLLER ##################
class UserManagerController:
    userService = UserService()
    def __init__(self):
        self.userModel = UserModel(id="", nom="", prenom="", mail="", role="", username="", password="")
        self.userView = UserView(self)

    def main(self):
        self.userView.main()

    def getUsers(self):
        users = self.userService.getAllUsers()
        return users
    def searchUser(self, radio, value):
        if radio == 1:
            user = self.userService.getUserById(value)
            print(user.getNom())
            self.userView.set_entries(user)
            self.userView.tree.selection_remove(self.userView.tree.selection())
        elif radio == 2:
            user = self.userService.getUserByEmail(value)
            print(user.getNom())
            self.userView.set_entries(user)
            self.userView.tree.selection_remove(self.userView.tree.selection())

    def addUser(self, userModel: UserModel):
        response = self.userService.addUser(userModel)
        print(response)
        if response == 1:
            messagebox.showinfo("Success", "User added successfully", parent=self.userView.win)
            self.userView.clear_entries()
            self.userView.draw_treeView()

    def updateUser(self, userModel: UserModel):
        response = self.userService.updateUser(userModel)
        print(response)
        if response == '1':
            messagebox.showinfo("Success", "User updated successfully ", parent=self.userView.win)
            self.userView.clear_entries()
            self.userView.draw_treeView()

    def deleteUser(self, id):
        result = messagebox.askquestion("Supprimer", "Etes vous sure de supprimer cet utilisateur?", icon='warning')
        if result == 'yes':
            response = self.userService.deleteUser(id)
            print(response)
            if response == '1':
                messagebox.showinfo("Success", "User deleted successfully ", parent=self.userView.win)
                self.userView.clear_entries()
                self.userView.draw_treeView()
        else:
            print("no")


if __name__ == '__main__':
    logController = LogController()
    logController.main()
    # userController = UserManagerController()
    # userController.main()
