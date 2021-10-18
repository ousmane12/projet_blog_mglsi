from tkinter import StringVar



class LoginModel:
    """
    Documentation de la classe
    """
    def __init__(self, login,passwd):
        """
        Constructeur
        """
        self._login = login
        self._password = passwd

    # getters and setters
    def getLogin(self):
        return self._login

    def getPassword(self):
        return self._password

    def setLogin(self, login):
        self._login = login

    def setPassword(self, passwd):
        self._password = passwd
class UserModel:

    def __init__(self, id, nom, prenom, mail, role,username, password,token):
        self._id = id
        self._nom = nom
        self._prenom = prenom
        self._mail = mail
        self._username = username
        self._role = role
        self._password = password
        self._token = token

    # Getters
    def getId(self):
        return self._id
    def getNom(self):
        return self._nom
    def getPrenom(self):
        return self._prenom
    def getMail(self):
        return self._mail
    def geStatut(self):
        return self._role

    # Setters
    def setNom(self,nom):
        self._nom = nom
    def setPrenom(self,prenom):
        self._prenom = prenom
    def setMail(self,mail):
        self._mail = mail
    def setStatut(self,statut):
        self._role = statut
