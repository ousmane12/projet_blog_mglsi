package service;

import java.security.NoSuchAlgorithmException;

import javax.jws.WebMethod;
import javax.jws.WebParam;
import javax.jws.WebService;

import dao.UserDAO;
import domaine.User;


@WebService(serviceName = "UsersManagementService")
public class SoapService {
    private UserDAO userDAO = new UserDAO();

    @WebMethod
    public User connect(@WebParam(name ="username") String username, @WebParam(name = "password") String password) throws NoSuchAlgorithmException{
        User user = new User();
        user.setUsername(username);
        user.setPassword(password);

        if(user.getId() != 0){
           // user.setToken(token);
        }
        return user;
    }
}
