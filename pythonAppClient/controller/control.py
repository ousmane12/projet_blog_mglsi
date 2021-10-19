from zeep import Client

from pythonAppClient.model.model import LoginModel, UserModel
from pythonAppClient.service.userService import UserService
from pythonAppClient.view.view import LogView, UserView


################## CLASS LOGIN CONTROLLER ##################
class LogController:
    def __init__(self):
        self.logModel = LoginModel(login="", passwd="")
        self.logView = LogView(self)

    def main(self):
        self.logView.main()

    def login(self, logModel: LoginModel):
        print(logModel.getPassword())
        if logModel.getLogin() == 'sow' and logModel.getPassword() == 'sow':
            print('Login success')
            self.logView.quit()
            userControl = UserManagerController()
            userControl.main()
        else:
            print("failed")

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
        elif radio == 2:
            user = self.userService.getUserByEmail(value)
            print(user.getNom())

    def addUser(self, userModel: UserModel):
        response = self.userService.addUser(userModel)
        print(response)
        if response == '1':
            self.userView.clear_entries()
            self.userView.draw_treeView()

    def updateUser(self, userModel: UserModel):
        response = self.userService.updateUser(userModel)
        print(response)
        if response == '1':
            self.userView.clear_entries()
            self.userView.draw_treeView()

    def deleteUser(self, id):
        response = self.userService.deleteUser(id)
        print(response)
        if response == '1':
            self.userView.clear_entries()
            self.userView.draw_treeView()


if __name__ == '__main__':
    # logController = LogController()
    # logController.main()
    userController = UserManagerController()
    userController.main()
