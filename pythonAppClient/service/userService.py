from zeep import Client

from pythonAppClient.model.model import UserModel


class UserService:

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

    def addUser(self, user:UserModel):
        responce = self.client.service.addUser(user.getNom(), user.getPrenom(), user.getUsername(), user.getPassword(), user.getMail(), user.getRole())
        return responce

    def authenticate(self, username, password):
        auth = self.client.service.authenticateUser(username,password)
        return auth
    def getUserByEmail(self, email):
        user = self.client.service.getUserByEmail(email)
        id = user['id']
        nom = user['nom']
        prenom = user['prenom']
        mail = user['email']
        role = user['role']
        username = user['username']
        password = user['password']
        userModel = UserModel(id=id, nom=nom, prenom=prenom, mail=mail, role=role, username=username, password=password)
        return userModel

    def getUserById(self, id):
        user = self.client.service.getUserById(id)
        id = user['id']
        nom = user['nom']
        prenom = user['prenom']
        mail = user['email']
        role = user['role']
        username = user['username']
        password = user['password']
        userModel = UserModel(id=id, nom=nom, prenom=prenom, mail=mail, role=role, username=username, password=password)
        return userModel
    def updateUser(self, user:UserModel):
        response = self.client.service.updateUser(user.getId(), user.getNom(), user.getPrenom(), user.getUsername(),
                                                  user.getPassword(), user.getMail(), user.getRole())
        return response

    def deleteUser(self, id):
        responsee = self.client.service.removeUser(id)
        return responsee


# user = UserService()
# user.authenticate(username='test', password='ok')
# user.getUserById(1)