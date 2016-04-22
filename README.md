# pc-discount
## Instalation

>Installer <a href="https://www.prestashop.com/">prestashop</a><br>
>Supprimer les dossier **modules**, **themes** et **override**
<br><br>
A la racine du site récupérer le projet : 
```
git init
git remote add origin https://github.com/iss936/pc-discount.git
git pull origin master
```

Ensuite dans la dans phpMyAdmin, ajoutez le thème du projet à liste des thèmes
```
INSERT INTO `prestashop`.`ps_theme` (`id_theme`, `name`, `directory`, `responsive`, `default_left_column`, `default_right_column`, `product_per_page`) VALUES (NULL, 'PC Discount', 'pcdiscount', '1', '0', '0', '12');
```
