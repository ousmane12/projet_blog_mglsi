package dao;
 
import domaine.User;

import java.util.ArrayList;

import Persistance.Database;

public class UserDAO extends Database{
    /**
     * Show a single user info by id
     * @param idUser
     * @return user
     */
    public User getUserById(int idUser){
        User user = new User();
		try 
		{
			this.statement = this.getConnexion().prepareStatement("SELECT * FROM User WHERE id = ?");
			this.statement.setInt(1, idUser);
			this.result = this.statement.executeQuery();
			while(this.result.next())
			{
				user.setId(this.result.getInt("id"));
                user.setUsername(this.result.getString("username"));
				user.setNom(this.result.getString("nom"));
				user.setPrenom(this.result.getString("prenom"));
				user.setEmail(this.result.getString("email"));
				user.setRole(this.result.getString("role"));
			}
			
		} 
		catch (Exception e) 
		{
			e.printStackTrace();
		}
		return user;
    }
    /**
     * Show all users
     * @return userList
     */

    public ArrayList<User> getAllUsers(){
        ArrayList<User> userList = new ArrayList<User>();

		User user;

		try {
			this.statement = this.getConnexion().prepareStatement("SELECT * FROM User");
			this.result = this.statement.executeQuery();
			while (this.result.next()) {
				user = new User();
				user.setId(this.result.getInt("id"));
				user.setEmail(this.result.getString("email"));
                user.setUsername(this.result.getString("username"));
				user.setNom(this.result.getString("nom"));
				user.setPrenom(this.result.getString("prenom"));
				user.setRole(this.result.getString("role"));
				userList.add(user);
			}
		} catch (Exception e) {
			System.out.println(e.getMessage());
		}
		
		return userList;
    }
    /**
     * add a new user
     * @param user
     * @return execution status
     */
    public int addUser(User user){
        try {
			this.statement = this.getConnexion().prepareStatement("INSERT INTO User(username,nom,prenom,email,role,password, token) VALUES(?,?,?,?,?,?,?)");
			this.statement.setString(1, user.getUsername());
            this.statement.setString(2, user.getNom());
			this.statement.setString(3, user.getPrenom());
			this.statement.setString(4, user.getEmail());
			this.statement.setString(5, user.getRole());
            this.statement.setString(6, user.getPassword());
			this.statement.setString(7, user.getToken());

			return this.statement.executeUpdate();
			
		} catch (Exception e) {
			System.out.println(e.getMessage());
		}  
        return 0;
    }

    /**
     * update user information
     * @param user
     * @return execution status
     */
    public int update(User user){
        try {
            this.statement = this.getConnexion().prepareStatement("UPDATE User SET username = ?, nom = ? , prenom = ? , email = ? , role = ?, password = ? WHERE id = ?");
            this.statement.setString(1, user.getUsername());
            this.statement.setString(2, user.getNom());
			this.statement.setString(3, user.getPrenom());
			this.statement.setString(4, user.getEmail());
			this.statement.setString(5, user.getRole());
            this.statement.setString(6, user.getPassword());
            this.statement.setInt(6, user.getId());

			return this.statement.executeUpdate();
        } catch (Exception e) {
            //TODO: handle exception
            e.printStackTrace();
        }
        return 0;
    }

    public int remove(int id){
        try {
            
            this.statement = this.getConnexion().prepareStatement("DELETE FROM User WHERE id = ? ");
			this.statement.setInt(1, id);
			return this.statement.executeUpdate();
        } catch (Exception e) {
            //TODO: handle exception
            e.printStackTrace();
        }
        return 0;
    }




}
