<?php
// config/nastavenia.php

return [
    // Pole typů projektů
    'typProjektu' => [
        0 => "Obecný projekt",
        1 => "Bakalářská práce",
        2 => "Diplomová práce",
        3 => "Disertační práce",
        4 => "Obecný projekt a BP",
        5 => "Obecný projekt a DP",
    ],

    // Pole stavů projektů
    'stavProjektu' => [
        0 => "Nezadaný",
        1 => "Řešený",
        2 => "Ukončený",
        3 => "K rozhodnutí",
    ],

    // Pole aktivit řešitelů
    'aktivitaResitele' => [
        0 => "neaktivni",
        1 => "d_skript",
        2 => "k_deaktivaci",
        3 => "k_aktivaci",
        4 => "a_skript",
        5 => "aktivni",
    ],

    // Pole aktivit osob
    'aktivitaOsoby' => [
        0 => "neaktivni",
        1 => "k_deaktivaci",
        2 => "k_aktivaci",
        3 => "aktivni",
    ],
  
    // Pole stavy ukolu
    'stavyUkolu' => [
        0 => "Smazaný",
        1 => "Nezadaný",
        2 => "Zadaný",
        3 => "Řešený",
        4 => "Vyřešený",
        5 => "Akceptovaný",
        6 => "Vrácený",
        7 => "Nejasný",
        8 => "Zodpovězený",
    ],
    'rodinnyStav' => [ 
        0 => "---",
        1 => "svobodný/svobodná",
        2 => "ženatý/vdaná",
        3 => "rozvedený/á",
        4 => "vdovec/vdova",
        5 => "partnertsví",
        6 => "mrtev/mrtvá",
        7 => "zaniklé partnerství rozhodnutím",
        8 => "zaniklé partnerství smrtí",
    ],
    'typOsoby' => [
    0 => "Bakalář",
    1 => "Diplomant",
    2 => "Doktorand",
    3 => "Ext. doktorand",
    4 => "Stud. spolupracovník",
    5 => "Zaměstnanec",
    6 => "Ostatní",
    7 => "Bakalář + SS",
    8 => "Diplomant + SS",
    9 => "Předmět",
    10 => "Zkušební doba",
    11 => "Nový stud. spolupracovník",
    12 => "Diplomant + Předmět",
    ],
    'colFilter' => [
        0 => "&sub; obsahuje",
        1 => "&nsub; neobsahuje",
        2 => "= rovná se",
        3 => "je prázdný",
        4 => "je neprázdný",
        5 => ">= větší nebo rovno",
        6 => "<= menší nebo rovno",
    ],
];
