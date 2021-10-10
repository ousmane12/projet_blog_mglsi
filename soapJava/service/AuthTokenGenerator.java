package service;

import java.util.ArrayList;

import dao.UserDAO;
import domaine.User;

public class AuthTokenGenerator {
    private static final String ALPHA_NUMERIC_STRING = "azertyuiopqsdfghjklmwxcvbn-_@ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	private ArrayList<User> allTokens;
	
	public AuthTokenGenerator() {
		UserDAO dao = new UserDAO();
		this.allTokens = dao.getAllUsers();
	}
	
	private boolean exist(String tok)
	{
		for(User user : allTokens)
		{
			if(user.getToken().equals(tok))
			{
				return true;
			}
		}
		return false;
	}

	private String randomAlphaNumeric() {

	StringBuilder builder = new StringBuilder();
	int count = (int) (Math.random()*(ALPHA_NUMERIC_STRING.length() - 10) + 1);

	while (count-- != 0) {

	int character = (int)(Math.random()*ALPHA_NUMERIC_STRING.length());

	builder.append(ALPHA_NUMERIC_STRING.charAt(character));

	}

	return builder.toString();

	}
	
	public String getToken()
	{
		String token = "";
		do {
			token = this.randomAlphaNumeric();
		} while (exist(token));
		return token;
	}
}
