
# Wypożyczalnia instrumentów muzycznych
Projekt powstał z myślą o usprawnieniu systemu wypożyczania instrumentów wszelkiego rodzaju dla małych firm. 

## Wymagania systemowe
* wersja apache'a: 2.4.41
* wersja PHP'a: 7.4.3
* wersja MySQL: 10.3.38

## Instalacja
0. Stworzenie pliku config.php w folderze config. Należy nadać uprawnienia umożliwiające edycję pliku przez pozostałych.
1. Po stworzeniu i nadaniu odpowiednich praw, powinien pojawić się formularz z konfiguracją niezbędną do połączenia się z bazą danych.
2. Odbywa się zapis do pliku config.php
3. Rozpoczyna się tworzenie tabel w bazie danych
4. Uzupełnia się tabele wartościami
5. Pojawia się formularz do stworzenia konta admina
6. Sprawdzanie czy formularz został poprawnie wypełniony
7. Kolejny formularz, tym razem dot. informacji firmy. Tutaj plik companyinfo.php powinien otrzymać uprawnienia umożliwiające edycję pliku przez pozostałych.
8. Koniec instalacji. W tym momencie powinno się wykasować plik installer.php (ewentualnie zmienić nazwę) 

## Autor

* **Magda Ustyniuk** 
* *nr  albumu: 398895*
* *manticore: magusty*

## Wykorzystane zewnętrzne biblioteki

* bootstrap wersja 5