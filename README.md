Zadanie praktyczne, PHP
Stwórz aplikację API RESTful przy użyciu framework-a Symfony w najświeższej stabilnej wersji.
Chcielibyśmy zobaczyć jak piszesz, więc aplikacja nie musi się uruchamiać, choć jeśli będzie działać, efekt
zobaczymy na własne oczy ;). Zwrócimy uwagę na wiele aspektów, m.in. wykorzystanie możliwości
framework-a, bezpieczeństwo, elegancję i jakość kodu.
Pomiń kwestię waluty, ewentualnego przewalutowania, rat wyrównujących.
Skorzystaj z załączonej konfiguracji kontenerów lub napisz własną.
Cała reszta zależy od Ciebie.
Życzymy owocnego kodzenia ;)
Kryteria akceptacji zadania
1. komunikacja jest zgodna z zasadami REST w formacie JSON,
2. zwracane dane są gotowe do wyświetlenia - nie będą poddane dalszej obróbce,
3. metoda kalkulacji wyliczająca harmonogram spłaty kredytu dla rat równych:
a. mechanizm liczący powinien uwzględniać stałe oprocentowanie (RRSO) kredytu i adekwatnie do
tego wyświetlać wartość odsetek dla każdej raty,
b. dane wejściowe:
i. kwota z przedziału <1000, 12000>, dopuszczalne są wartości podzielne przez 500, czyli kwota
1230 jest niepoprawna, a kwota 2500 jest poprawna,
ii. liczba rat z przedziału <3, 18>, dopuszczalne są wartości podzielne przez 3,
c. odpowiedź zawiera:
i. metrykę kalkulacji: chwila kalkulacji, liczba rat, kwota, oprocentowanie,
ii. harmonogram rat zawierający: nr raty, kwotę raty, kwotę odsetek, kwotę kapitału,
4. metoda pozwalająca na wykluczenie pojedynczej kalkulacji:
a. dostęp chroniony jest kluczem JWT,
5. metoda listująca kalkulacje (4 ostatnie) uporządkowane wg sumarycznej kwoty odsetek malejąco:
a. dostęp chroniony jest kluczem JWT,
b. dostępna jest filtracja: wszystkie (opcja domyślna), tylko niewykluczone
6. aplikacja posiada podstawową dokumentację,
7. kod dostępny jest w publicznym repozytorium kodu, np. GitHub.

![wzor](https://github.com/user-attachments/assets/1399a98e-f746-4805-b9ad-7ad8de37e1d0)

Wzór dla wyliczenia pojedynczej raty udzielonego kredytu, gdzie:
R – kwota raty kredytu
N – kwota kredytu
r – oprocentowanie kredytu w skali roku
k – liczba rat w ciągu roku
n – liczba rat kredytu (okres kredytowania)
