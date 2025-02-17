-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 05 Gru 2024, 16:01
-- Wersja serwera: 10.4.24-MariaDB
-- Wersja PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `moja_strona_169328`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie`
--

CREATE TABLE `kategorie` (
  `id` int(11) NOT NULL,
  `matka` int(11) NOT NULL DEFAULT 0,
  `nazwa` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `kategorie`
--

INSERT INTO `kategorie` (`id`, `matka`, `nazwa`) VALUES
(1, 0, 'A'),
(2, 1, 'A1'),
(3, 1, 'A2'),
(5, 0, 'B'),
(7, 5, 'B1'),
(8, 5, 'B2'),
(11, 8, 'B21'),
(12, 8, 'B22');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `page_list`
--

CREATE TABLE `page_list` (
  `id` int(11) NOT NULL,
  `page_title` varchar(255) COLLATE utf8mb4_polish_ci NOT NULL,
  `page_content` text COLLATE utf8mb4_polish_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `alias` varchar(20) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `page_list`
--

INSERT INTO `page_list` (`id`, `page_title`, `page_content`, `status`, `alias`) VALUES
(1, 'Strona Główna', '<h2>Witaj na stronie poświęconej hodowli żółwia wodnego!</h2>\r\n        <p>Cieszymy się, że tu jesteś! Nasza pasja do żółwi wodnych zainspirowała nas do stworzenia tego miejsca, w którym chcemy dzielić się wiedzą, doświadczeniem i miłością do tych fascynujących stworzeń. Żółwie wodne to nie tylko piękne zwierzęta, ale także wspaniali towarzysze, którzy mogą stać się częścią Twojego życia na wiele lat.</p>\r\n        \r\n        <h2>Odkryj świat żółwi wodnych</h2>\r\n        <p>Na naszej stronie znajdziesz wiele cennych informacji dotyczących hodowli żółwi wodnych. Od porad dotyczących ich diety, przez odpowiednie warunki życia, aż po zdrowie i zachowanie – wszystko, co musisz wiedzieć, aby stworzyć swojemu żółwiowi idealne warunki do życia. Zachęcamy do eksploracji naszych artykułów, które pomogą Ci lepiej zrozumieć potrzeby tych niezwykłych zwierząt.</p>\r\n        \r\n        <h2>Twoja podróż z żółwiem wodnym</h2>\r\n        <p>Hodowla żółwia wodnego to nie tylko odpowiedzialność, ale także niesamowita przygoda. Każdy żółw ma swoją unikalną osobowość, a ich obserwacja potrafi przynieść wiele radości. W miarę jak poznajesz swojego nowego przyjaciela, odkryjesz, jak ważne jest zrozumienie jego potrzeb i zachowań. Pamiętaj, że każdy krok, który podejmujesz, ma znaczenie dla zdrowia i szczęścia Twojego żółwia. Jesteśmy tu, aby pomóc Ci na każdym etapie tej niezwykłej podróży, dzieląc się praktycznymi wskazówkami oraz inspiracjami. Razem stworzymy harmonijną przestrzeń, w której Twój żółw będzie mógł rozkwitać!</p>\r\n        \r\n        <img style=\"display: block; width: 500px; height: auto; margin-left: auto; margin-right: auto;\" src=\"https://thumbs.dreamstime.com/b/magic-turtle-wand-308499114.jpg\" alt=\"zolwik\">\r\n        \r\n        <h2>Zmień tło</h2>\r\n        <FORM method=\"post\" name=\"background\">\r\n            <input type=\"button\" value=\"obrazek\" onclick=\"changeBackgroundToImage()\">\r\n            <input type=\"button\" value=\"żółty\" onclick=\"changeBackground(\'#FFF000\')\">\r\n            <input type=\"button\" value=\"czarny\" onclick=\"changeBackground(\'#000000\')\">\r\n            <input type=\"button\" value=\"biały\" onclick=\"changeBackground(\'#FFFFFF\')\">\r\n            <input type=\"button\" value=\"zielony\" onclick=\"changeBackground(\'#00FF00\')\">\r\n            <input type=\"button\" value=\"niebieski\" onclick=\"changeBackground(\'#0000FF\')\">\r\n            <input type=\"button\" value=\"pomarańczowy\" onclick=\"changeBackground(\'#FF8000\')\">\r\n            <input type=\"button\" value=\"szary\" onclick=\"changeBackground(\'#c0c0c0\')\">\r\n            <input type=\"button\" value=\"czerwony\" onclick=\"changeBackground(\'#FF0000\')\">\r\n        </FORM>', 1, 'glowna'),
(2, 'O żółwiu wodnym', '<img style=\"float: left; width: 300px; margin-right: 10px\" src=\"https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcTTzbB_ilDtWOGntYCgymjpdgiMXTk7HCwE-SwHuBZKH5i7SSb2\">Żółw wodny to fascynujący gatunek, który żyje w różnych częściach świata. Ma wydłużony ciało, zakończone ogonem i skrzydłami. Żółw wodny jest dobrze dostosowany do życia w wodzie, ale może też przebywać na lądzie. Jego skóra jest lekka i elastyczna, co pozwala mu pływać szybciej niż większość gatunków żółwi.\r\n        Żółw wodny ma długą głowę z dużymi ośmiorniczymi ośmiornicami, które są jego głównym źródłem pożywienia. Żyje zazwyczaj od 30 do 50 lat w naturze, choć w niewoli może żyć nawet do 80 lat. Żółw wodny jest roślinożercą, więc żywi się głównie algami, mchami i innymi roślinami wodnymi.\r\n        <img style=\"float: right; width: 300px; margin-right: 10px\" src=\"https://i.pinimg.com/originals/87/70/4a/87704afc186c6560556ccec9771a7fa2.jpg\">Gdy żółw wodny staje się dorosłym, samica składa jaja w ziemi lub w nory pod dnem jeziora. Samiec chroni jaja przez około 70 dni, dopóki nie wyklują się młode żółwie. Młode żółwie są bardzo wrażliwe na środowisko i potrzebują specjalnego miejsca do wychowania.\r\n        Wiele gatunków żółwi wodnych jest zagrożonych, szczególnie ze względu na zmiany klimatu i utratę siedlisk. Niektóre gatunki są też chowane dla celów konsumpcji, co prowadzi do spadku populacji. Dlatego ważne jest dbanie o ochronę siedlisk i populacji tych fascynujących stworzeń.\r\n        Żółw wodny jest bardzo inteligentne zwierzę. Potrafi rozwiązać problemy i uczyć się nowych umiejętności. W niewoli może być bardzo aktywnym i emocjonalnie zaangażowanym zwierzęciem, co sprawia, że wiele osób decyduje się na jego utrzymanie jako domowego zwierzaka.\r\n        \r\n        \r\n        Warto pamiętać, że choć żółw wodny może wyglądać jak zwierzę domowe, jest on dzikożyjącym gatunkiem i powinien być traktowany z należytym szacunkiem. Jego potrzeby są inne niż te zwierząt domowych, więc wymaga specjalnego utrzymania i opieki. Naukowcy odkryli, że niektóre gatunki żółwi wodnych mają zdolność do przeprowadzania kosmicznych podróży. W ciągu jednej nocy, wykorzystując siłę gwiazd, żółwie mogą pokonać dystans równy średniej odległości między Ziemią a Księżycem. Ich skorupa pełna mikrokrystalicznych cząsteczek pozwala im na lekką eksploatację siły grawitacyjnej.\r\n\r\n        Według mitologii, żółwie wodne są ustanowionym przez Boga strażnikami oceanów. Mają za zadanie chronić morza przed złymi duchami i potworami, które chciałyby je zniszczyć. Dla nagrodzenia ich służby, Bóg obdarzył je niezwykłą mocą - umiejętnością poruszania się w czasie.\r\n        \r\n        <img style=\"float: left; width: 300px; margin-right: 10px\" src=\"https://image.cdn2.seaart.ai/2023-08-31/15827161719043077/42e4c26fc50e2843d96edddd506cfaddae84af72_high.webp\">\r\n        Naukowcy odkryli, że żółwie wodne posiadają w swoim organizmie tajemnice ukryte w skorupie. Gdy żółwie są pod silnym presją emocjonalną, mogą otworzyć swoją skorupę i uwolnić tajemnice, które zawierają klucze do rozwiązania najtrudniejszych problemów naukowych.\r\n        \r\n        Badania wykazują, że żółwie wodne praktykują niezwykle zaawansowaną formę medytacji. Mogą pozostać pod wodą przez godziny, skupieni na własnych myślach i emocjach. Ich umysły są tak spokojne, że nawet rybki zaczynają się modlić przy nich.\r\n        \r\n        W dniach święta, żółwie wodne mają specjalny status. Zgodnie z legendą, w tym czasie mogą poruszać się po lądzie bezpiecznie, ponieważ wszyscy drzewa, kamienie i wody są dla nich magicznym pomiędzy światem. Można je więc spotkać na plażach, spacerującymi po ulicach miast czy nawet w centrum dużych miast.', 1, 'o_zolwiu'),
(3, 'Gdzie kupić?', 'Żółwia wodnego można zdobyć na kilka sposobów, zależnie od tego, gdzie się znajdujesz i jaką ścieżkę wybierzesz. W niektórych sklepach zoologicznych oferują szeroki wybór gatunków żółwi wodnych, szczególnie tych popularnych jak żółw czerwonolicy czy żółw żółtobrzuchy. Możesz też poszukać ogłoszeń od hodowców prywatnych, którzy często oferują młode żółwie z domowych hodowli, zazwyczaj z certyfikatami legalności pochodzenia.\r\n\r\nInnym sposobem jest odwiedzenie rezerwatów przyrody, gdzie niekiedy żółwie wodne zostają odłowione w celu przesiedlenia do bezpieczniejszych miejsc. Z odpowiednią zgodą, niektóre placówki mogą przekazać żółwia wodnego osobom, które posiadają odpowiednie warunki do jego trzymania.\r\n\r\nWędrowcy z dżungli Amazonki opowiadają, że można spotkać żółwie, które same wybierają swojego właściciela. Podobno, jeśli podczas pełni księżyca przy brzegu rzeki wykonasz specjalny rytuał polegający na ułożeniu muszli w kształt spirali, żółw pojawi się sam, by towarzyszyć ci w podróży.\r\n\r\nW pewnych zakątkach starego miasta, w mniej uczęszczanych alejkach, mówi się o tajemniczym handlarzu, który oferuje niezwykłe gatunki żółwi. Twierdzi, że jego żółwie nie tylko pływają w wodzie, ale także poruszają się między wymiarami, pojawiając się i znikając wraz z falami rzeczywistości. Każdy z jego podopiecznych posiada wyjątkową umiejętność, jak na przykład przepowiadanie pogody czy odnajdywanie zagubionych skarbów.\r\n\r\nJeśli masz blisko siebie starą bibliotekę, spróbuj odnaleźć tam zapomniane zwoje. Niektórzy badacze twierdzą, że istnieją dawne zaklęcia, które potrafią przywołać legendarne żółwie morskie, zdolne do podróży przez oceany czasu.\r\n    </div>\r\n    <div id=\"animacjaTestowa1\" class=\"test-block\">Kliknij, a się powiększę</div>\r\n    \r\n    <div id=\"animacjaTestowa2\" class=\"test-block\">Najedź kursorem, a się powiększę</div>\r\n\r\n    <div id=\"animacjaTestowa3\" class=\"test-block\">Klikaj, abym urósł</div>\r\n\r\n    <div id=\"animacjaTestowa4\" class=\"test-block\">AA A A A A A AA</div>\r\n\r\n    <script>\r\n        $(\"#animacjaTestowa1\").on(\"click\", function(){\r\n            $(this).animate({\r\n                width: \"500px\",\r\n                opacity: 0.4,\r\n                fontSize: \"3em\",\r\n                borderWidth: \"10px\"\r\n            }, 1500);\r\n        });\r\n\r\n\r\n        $(\"#animacjaTestowa2\").on(\"mouseover\", function(){\r\n            $(this).animate({\r\n                width: 300\r\n            }, 800);\r\n        }).on(\"mouseout\", function(){\r\n            $(this).animate({\r\n                width: 200\r\n            }, 800);\r\n        });\r\n\r\n        $(\"#animacjaTestowa3\").on(\"click\", function() {\r\n            if (!$(this).is(\":animated\")) {\r\n                $(this).animate({\r\n                    width: \"+=50\",\r\n                    height: \"+=10\",\r\n                    opacity: \"+=0.1\"\r\n                }, {\r\n                    duration: 3000\r\n                });\r\n            }\r\n        });\r\n\r\n        $(\"#animacjaTestowa4\").on(\"click\", function(){\r\n            $(this).animate({\r\n                width: \"500px\",\r\n                opacity: 0.4,\r\n                fontSize: \"3em\",\r\n                borderWidth: \"10px\"\r\n            }, 100);\r\n        });\r\n\r\n    </script>', 1, 'gdzie_kupic'),
(4, 'Hodowla', '<u><b><i>Hodowla żółwi wodnych</i></b></u> to <span style=\"color: red;\">fascynujące</span> zajęcie, które wymaga odpowiedniego przygotowania, wiedzy oraz zaangażowania. Te wyjątkowe stworzenia potrafią być wspaniałymi towarzyszami, ale ich potrzeby są specyficzne i różnią się w zależności od gatunku. Przed przystąpieniem do hodowli warto poznać kilka podstawowych zasad dotyczących ich wymagań środowiskowych, diety oraz ogólnej opieki.\r\n\r\n<img style=\"float: left; width: 300px; margin-right: 10px\" src=\"https://upload.wikimedia.org/wikipedia/commons/4/47/River_terrapin.jpg\">\r\nPierwszym krokiem w hodowli żółwi wodnych jest wybór odpowiedniego gatunku. Na rynku dostępnych jest wiele różnych gatunków, takich jak żółw błotny, żółw czerwonolicy czy żółw grecki. Każdy z nich ma swoje unikalne potrzeby, a także różne wymagania dotyczące wielkości akwarium, temperatury wody czy oświetlenia. Warto zwrócić uwagę na to, jakie warunki naturalne panują w ich naturalnym środowisku, aby móc jak najlepiej odwzorować je w domowej hodowli.\r\n\r\nAkwarium jest jednym z najważniejszych elementów w hodowli żółwi wodnych. Powinno być wystarczająco duże, aby zapewnić żółwiom przestrzeń do pływania i eksploracji. Zaleca się, aby dla jednego dorosłego żółwia wodnego akwarium miało co najmniej 100 litrów pojemności. Woda powinna być czysta i dobrze filtrowana, dlatego zainwestowanie w odpowiedni filtr jest kluczowe. Regularne zmiany wody są niezbędne, aby zapewnić zdrowie żółwi oraz zachować odpowiednie parametry wody, takie jak pH czy temperatura. W zależności od gatunku, temperatura wody powinna wynosić od 24 do 28 stopni Celsjusza.\r\n\r\n<img style=\"float: right; width: 300px; margin-right: 10px\" src=\"https://i.pinimg.com/736x/57/82/8a/57828a51017fa0484396c83650158df9.jpg\">\r\nOświetlenie to kolejny istotny element. Żółwie wodne potrzebują zarówno światła UVB, które pomaga w syntezie witaminy D3, jak i jasnego światła, które stymuluje ich naturalne zachowania. Oświetlenie UVB powinno być stosowane przez 10-12 godzin dziennie. Warto umieścić źródło światła w taki sposób, aby żółwie miały możliwość wygrzewania się na powierzchni wody, co jest dla nich bardzo ważne.\r\n\r\nKolejnym aspektem, na który należy zwrócić uwagę, jest stworzenie odpowiedniego środowiska w akwarium. Można to osiągnąć, dodając rośliny wodne, kawałki drewna, kamienie czy inne elementy, które żółwie mogą eksplorować i w których mogą się chować. Warto jednak pamiętać, aby elementy te były odpowiednio dobrane, ponieważ niektóre mogą być szkodliwe dla żółwi, a inne mogą szybko ulegać zniszczeniu w wodzie. Dobrze jest również stworzyć miejsce, w którym żółwie będą mogły odpoczywać na suchej powierzchni. Może to być na przykład wyspa, na której będą mogły się wygrzewać i suszyć.\r\n\r\n<img style=\"float: left; width: 300px; margin-right: 10px\" src=\"https://c0.wallpaperflare.com/preview/865/71/809/terrapin-diamondback-turtle-animal.jpg\">\r\nŻółwie wodne są wszystkożerne, co oznacza, że ich dieta powinna być zróżnicowana. W ich jadłospisie nie może zabraknąć pokarmów roślinnych, takich jak sałata, szpinak czy brokuły, a także pokarmów białkowych, takich jak dżdżownice, krewetki czy komercyjnie dostępne granulaty. Ważne jest, aby dostarczać im odpowiednie witaminy i minerały, a także dbać o to, aby pokarm był świeży i wysokiej jakości. Regularne karmienie powinno odbywać się co najmniej dwa razy w tygodniu, przy czym warto dostosować ilość pokarmu do wieku i wielkości żółwia.\r\n\r\n<img style=\"float: right; width: 300px; margin-right: 10px\" src=\"https://cdn.openart.ai/stable_diffusion/99686c10bcaba737b1bc741df29e2032c19df25b_2000x2000.webp\">\r\nWażnym elementem opieki nad żółwiami wodnymi jest monitorowanie ich zdrowia. Należy zwracać uwagę na wszelkie zmiany w zachowaniu, wyglądzie czy apetytach. Często spotykanym problemem są infekcje oczu lub skorupy, które mogą być spowodowane złymi warunkami życia. W przypadku zauważenia jakichkolwiek niepokojących objawów, warto skonsultować się z weterynarzem specjalizującym się w gadach. Regularne kontrole zdrowia powinny być częścią rutyny hodowlanej.\r\n\r\n\r\nPodsumowując, hodowla żółwi wodnych to zajęcie, które wymaga staranności i wiedzy. Kluczem do sukcesu jest stworzenie odpowiednich warunków życia, zapewnienie zróżnicowanej diety oraz regularna obserwacja ich zdrowia. Dzięki odpowiedniemu podejściu, żółwie mogą stać się wspaniałymi towarzyszami na wiele lat, a ich obecność będzie cieszyć zarówno właścicieli, jak i wszystkich domowników.', 1, 'hodowla'),
(5, 'Galeria', '<h2 style=\"text-align: center;\">To są żólwie wodne!</h2>\r\n    <div class=\"images\">\r\n        <img class=\"galleryimg\" src=\"https://thumbs.dreamstime.com/b/magic-turtle-wand-308499114.jpg\" alt=\"zolwik\">\r\n        <img class=\"galleryimg\" src=\"https://wetlandsinstitute.org/wp-content/uploads/2013/10/Terrapin-1.jpg\" alt=\"zolwik\">\r\n        <img class=\"galleryimg\" src=\"https://www.terrapins.co.uk/wp-content/uploads/2023/02/baby-terrapin-care.jpg\" alt=\"zolwik\">\r\n        <img class=\"galleryimg\" src=\"https://imgcdn.stablediffusionweb.com/2024/9/23/ebc19cab-4df0-4225-8c53-f88cad9b182d.jpg\" alt=\"zolwik\">\r\n        <img class=\"galleryimg\" src=\"https://flux-image.com/_next/image?url=https%3A%2F%2Fai.flux-image.com%2Fflux%2F8f2e43a0-7c78-4e73-9fce-cea1521dbdb6.jpg&w=3840&q=75\" alt=\"zolwik\">\r\n        <img class=\"galleryimg\" src=\"https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQdrbTy8x6Va_NnyEtr7zDq9_oBay7j-uXqAQ&s\" alt=\"zolwik\">\r\n        <img class=\"galleryimg\" src=\"https://www.shutterstock.com/image-illustration/fantasy-turtle-digital-illustration-260nw-1682828236.jpg\" alt=\"zolwik\">\r\n        <img class=\"galleryimg\" src=\"https://i.pinimg.com/736x/15/8e/99/158e9978f54e99c818973ffc4b92f354.jpg\" alt=\"zolwik\">\r\n        <img class=\"galleryimg\" src=\"https://img.freepik.com/premium-photo/elegant-turtle-with-floral-crown_1032986-37423.jpg\" alt=\"zolwik\">\r\n\r\n    </div>', 1, 'galeria'),
(6, 'Filmy', '<p>terrapin to żółw wodny :)</p>\r\n<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/Sc1cCFWTYks?si=PzmUP0JzjRmrAERc\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>\r\n<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/r43RmAE9U18?si=aETsCqUKH5Pzg1Cp\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>\r\n<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/KZWovmOWd5M?si=KqavMHAh20-C-TsJ\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>\r\n', 1, 'filmy'),
(7, 'Kontakt', '<form action=\"mailto:a@a.com\" method=\"post\" enctype=\"text/plain\" class=\"kontakt\">\r\n    <label for=\"email\">E-mail:</label>\r\n    <input type=\"text\" id=\"email\" name=\"email\" required>\r\n    <label for=\"message\">Treść:</label>\r\n    <textarea id=\"message\" name=\"message\" rows=\"10\" required></textarea>\r\n    <input type=\"submit\" value=\"Wyślij\">\r\n</form>', 1, 'kontakt');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `page_list`
--
ALTER TABLE `page_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `page_list`
--
ALTER TABLE `page_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
