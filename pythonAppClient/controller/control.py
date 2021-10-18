from zeep import Client

from pythonAppClient.model.model import LoginModel, UserModel
from pythonAppClient.view.view import LogView, UserView

client = Client('http://localhost/projet_blog_mglsi/soapService/service/UserController.php?wsdl')
result = client.service.getAllUserList()
print(result)

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

    def __init__(self):
        self.userModel = UserModel(id="", nom="", prenom="", mail="", role="")
        self.userView = UserView(self)

    def main(self):
        self.userView.main()

    def getUsers(self):
        users = []
        user1 = UserModel(id=1, nom='sow', prenom='ousmane', mail='sow@gmail.com', role='admin')
        user2 = UserModel(id=2, nom='barry', prenom='hams', mail='barry@gmail.com', role='editeur')
        user3 = UserModel(id=3, nom='mbaye', prenom='ababacar', mail='mbaye@gmail.com', role='editeur')
        users.append(user1)
        users.append(user2)
        users.append(user3)
        return users

    def addUser(self, userModel: UserModel):
        print("Add")
        print(f'From User controller: {userModel.getNom()}')

    def updateUser(self, userModel: UserModel):
        print("Update")
        print(f'From User controller: {userModel.getNom()}')

    def deleteUser(self, userModel: UserModel):
        print("Delete")
        print(f'From User controller: {userModel.getNom()}')


if __name__ == '__main__':
    logController = LogController()
    logController.main()

