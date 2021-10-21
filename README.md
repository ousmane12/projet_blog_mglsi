# Projet Blog M1GLSI NEWS

Ceci est un projet realisé dans le cadre de notre cours d'introduction a l'architecture logicielle. Année 2020-2021
## Installation avant d'executer le projet

Pour utiliser l'application client il faut tout d'abord installer [python](https://www.python.org/). 
Ensuite installer [zeep](https://pypi.org/project/zeep/) via pip.

```bash
pip install zeep
```
## Lien video youtube explicative

- https://youtu.be/yzlKguMLwHI

## Utilisation

De prime abord il faut creer des utilisateurs afin de pouvoir publier des articles via l'application client qui utilise le service soap pour
ajouter, modifier et/ou supprimer des utilisateurs puis les donner un role. Les roles retenus ici sont:
- les editeurs (editeur): qui peuvent ajouter, modifier et/ou supprimer leurs articles et/ou categories
- les administrateurs (admin) qui sont les superutilisateurs c'est a dire ils peuvent agir sur tout article et categorie

En creant ces utilisateurs vous aurez la possibilité d'ajouter des articles. Ou si non les explorer tout juste.

Pour ce qui est de l'API REST, il faut s'authentifier avant toute utilisation. C'est ainsi que les tokens créés lors de la
creation des utilisateurs sera utilisé.
Pour Accedder a la documentation de l'API, il faut aller sur l'url: http://localhost/projet_blog_mglsi/rest

En ce qui concerne le SOAP, on peut avoir l'arbre du wsdl sur l'url: http://localhost/projet_blog_mglsi/soapService/UserController.php?wsdl

## Contributeurs

<a href="https://github.com/sow37">
  <img src="https://github.com/sow37.png?size=50">
</a>
<a href="https://github.com/aristdev">
  <img src="https://avatars.githubusercontent.com/u/37861646?v=4">
</a>
<a href="https://github.com/ousmane12">
  <img src="https://github.com/ousmane12.png?size=50">
</a>



## Contribution
Les demandes de pull sont les bienvenues. Pour les changements majeurs, veuillez d'abord ouvrir un problème pour discuter de ce que vous aimeriez changer.

Veuillez vous assurer de mettre à jour les tests le cas échéant.

## License
[MGLSI](https://www.esp.sn/)
