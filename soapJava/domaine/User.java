package domaine;

import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;

import javax.xml.bind.annotation.XmlRootElement;

@XmlRootElement
public class User {
    private int id;
    private String nom;
    private String prenom;
    private String username;
    private String email;
    private String role;
    private String password;
    private String token;

    public User() {
    }

    public User(int id, String nom, String prenom, String username, String email, String role, String password,
            String token) {
        this.setId(id);
        this.setUsername(username);
        this.setPassword(password);
        this.setToken(token);
        this.setEmail(email);
        this.setRole(role);
    }

    public User(int id, String username,String nom, String prenom, String password, String token) {
        this.setId(id);
        this.setNom(nom);
        this.setPrenom(prenom);
        this.setUsername(username);
        this.setPassword(password);
        this.setToken(token);
    }

    public User(User user) {
        this(user.getId(), user.getNom(), user.getPrenom(), user.getUsername(), user.getEmail(), user.getRole(),
                user.getPassword(), user.getToken());
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    public String getPrenom() {
        return prenom;
    }

    public void setPrenom(String prenom) {
        this.prenom = prenom;
    }

    public String getUsername() {
        return this.username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) throws NoSuchAlgorithmException {
        this.password = getSecurePassword(getSHA1SecurePassword(password));
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getRole() {
        return role;
    }

    public void setRole(String role) {
        this.role = role;
    }

    public String getToken() {
        return token;
    }

    public void setToken(String token) {
        this.token = token;
    }

    private String getSecurePassword(String passwordToHash) throws NoSuchAlgorithmException {
        String generatedPassword = null;
        MessageDigest md = MessageDigest.getInstance("MD5");
        // Add password bytes to digest
        md.update(passwordToHash.getBytes());
        // Get the hash's bytes
        byte[] bytes = md.digest();
        // Convert it to hexadecimal format
        StringBuilder sb = new StringBuilder();
        for (int i = 0; i < bytes.length; i++) {
            sb.append(Integer.toString((bytes[i] & 0xff) + 0x100, 16).substring(1));
        }
        // Get complete hashed password in hex format
        generatedPassword = sb.toString();
        return generatedPassword;
    }

    private String getSHA1SecurePassword(String passwordToHash) throws NoSuchAlgorithmException {
        String generatedPassword = null;
        MessageDigest md = MessageDigest.getInstance("SHA-1");
        // Add password bytes to digest
        md.update(passwordToHash.getBytes());
        // Get the hash's bytes
        byte[] bytes = md.digest();
        // Convert it to hexadecimal format
        StringBuilder sb = new StringBuilder();
        for (int i = 0; i < bytes.length; i++) {
            sb.append(Integer.toString((bytes[i] & 0xff) + 0x100, 16).substring(1));
        }
        // Get complete hashed password in hex format
        generatedPassword = sb.toString();
        return generatedPassword;
    }
}