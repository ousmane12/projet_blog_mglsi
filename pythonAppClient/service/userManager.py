from zeep import Client

from pythonAppClient.model.model import UserModel


class UserManager:

    def __init__(self):
        self.userList = []
        self.client = Client('http://localhost/projet_blog_mglsi/soapService/service/UserController.php?wsdl')

    # retourne une liste d'objet de UserModel
    def getAllUsers(self):
        users = self.client.service.getAllUserList()
        for user in users:
            id = user['id']
            nom = user['nom']
            prenom = user['prenom']
            mail = user['email']
            role = user['role']
            username = user['username']
            password = user['password']
            userModel = UserModel(id=id, nom=nom, prenom=prenom, mail=mail, role=role, username=username, password=password)
            self.userList.append(userModel)
        return self.userList
    def authenticate(self, username, password):
        auth = self.client.service.authenticateUser(username,password)
        print(auth)
    def getUserByEmail(self, email):
        pass
    def getUserById(self, id):
        user = self.client.service.getUserById(id)
        print(user)
    def updateUser(self, user:UserModel):
        responce = self.client.service.updateUser(user.getId(), user.getNom(), user.getPrenom(), user.getUsername(),
                                                  user.getPassword(), user.getMail(), user.getRole())
        print(responce)

    def deleteUser(self, id):
        responce = self.client.service.deleteUser()

user = UserManager()
# user.authenticate(username='test', password='ok')
user.getUserById(1)