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
8. Koniec instalacji. W tym momencie powinno się wykasować plik installer.php (ewentualnie zmienić jego nazwę) 

## Wykorzystane zewnętrzne biblioteki

* bootstrap wersja 5

## Opis funkcjonalności poszczególnych użytkowników
1. Użytkownik niezalogowany 
  - przeglądanie ofert instrumentów
  - rejestracja
  - logowanie
  - przeglądanie kontaktu

2. Użytkownik zalogowany 
  - Wylogowanie 
  - przeglądanie kontaktu
Oferta:
  - formularz z zapytaniem o instrument 
  - przeglądanie informacji o instrumencie 
  - wypożyczanie instrumentów
Kontakt:
  - przeglądanie informacji kontaktowych
Rozwijane menu:
  a) mój profil: 
    - zmiana hasła
    - edycja danych
  b) zgłoszenia: 
    - wyświetlanie listy zgłoszeń oraz zawartości konkretnego zgłoszenia
  c) lista wypożyczonych instrumentów
    - anulowanie rezerwacji(jeżeli status jest zarezerwowany) 

3. Pracownik
  - Wylogowanie
  - Oferta:
  - możliwość wypożyczenia dla klienta, przeglądanie informacji o instrumencie, sprawdzenie ceny dla wybranego warunku
  - Kontakt:
  - przeglądanie informacji kontaktowych
  - Rozwijane menu
  a) Profil:
      - zmiana hasła, edycja danych
  b) Zgłoszenia: 
      - wyświetlanie listy nieodpowiedzianych zgłoszeń, zgłoszenia na które odpowiedział zalogowany pracownik
  b1) Zgłoszenie:
      - wyświetlanie szczegółów zapytań, odpowiadanie na wybrane zapytanie
  c) Lista wypożyczeń: 
      - przeglądanie dzisiejszych odbiorów/zwrotów instrumentów, przeglądanie jutrzejszych odbiorów/zwrotów instrumentów, przeglądanie wszystkich rezerwacji i wypożyczeń, wyświetlenie szczegółów wypożyczenia,        zmiana statusu wypożyczenia, odnotowywanie płatności klienta, odnotowywanie wpłaty kaucji
  d) Lista klientów:
      - wyświetlanie listy klientów

4. Administrator 
- Wylogowanie
Strona główna:
- dodanie nowej lokalizacji, zobaczenie listy lokalizacji, edycja strony głównej 
Oferta:
- możliwość ukrycia instrumentu, przeglądanie szczegółów instrumentu, edycja instrumentu
Kontakt: 
- edycja telefonu, nazwy firmy, adresu i emaila
Rozwijane menu:
a) Profil:
- zmiana hasła, edycja danych
b) Zgłoszenia: 
- wyświetlanie wszystkich zgłoszeń, wyświetlenie zamkniętych zgłoszeń, wyświetlenie zgłoszeń na które admin odpowiedział, wyświetlanie szczegółów zapytań, odpowiadanie na wybrane zapytanie
c) Lista wypożyczeń: 
- przeglądanie dzisiejszych zwrotów/odbiorów, jutrzejszych zwrotów/odbiorów, wyświetlanie wszystkich wypożyczeń
c1) przeglądanie detali konkretnego wypożyczenia
d) Lista użytkowników: 
- przeglądanie zarejestrowanych użytkowników, dodawanie nowego pracownika, wyświetlanie listy pracowników, dezaktywacja/aktywacja pracownika
e) Lista wypożyczalni: 
- przeglądanie adresów wypożyczalni, dodawanie nowego adresu, ukrywanie obecnych adresów
f) Lista płatności:
- admin może zobaczyć jakie płatności zostały wykonane oraz sprawdzić szczegóły wypożyczenia
g) Lista instrumentów: 
- dodawanie nowych produktów, sprawdzanie stanu obecnych instrumentów, ukrycie instrumentu, edytowanie ceny kaucji oraz kosztu na dzień w wybranym instrumencie
g1) Kategorie instrumentów: 
- dodawanie nowych kategorii oraz edytowanie zdjęcia w wybranej kategorii.


