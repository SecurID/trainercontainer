<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validierungs-Sprachzeilen
    |--------------------------------------------------------------------------
    |
    | Die folgenden Sprachzeilen enthalten die Standard-Fehlermeldungen, die von
    | der Validierungs-Klasse verwendet werden. Einige dieser Regeln haben
    | mehrere Versionen, wie zum Beispiel die Größenregeln. Du kannst diese
    | Nachrichten hier gerne anpassen.
    |
    */

    'accepted' => 'Das :attribute muss akzeptiert werden.',
    'active_url' => 'Das :attribute ist keine gültige URL.',
    'after' => 'Das :attribute muss ein Datum nach dem :date sein.',
    'after_or_equal' => 'Das :attribute muss ein Datum nach oder gleich dem :date sein.',
    'alpha' => 'Das :attribute darf nur Buchstaben enthalten.',
    'alpha_dash' => 'Das :attribute darf nur Buchstaben, Zahlen, Bindestriche und Unterstriche enthalten.',
    'alpha_num' => 'Das :attribute darf nur Buchstaben und Zahlen enthalten.',
    'array' => 'Das :attribute muss ein Array sein.',
    'before' => 'Das :attribute muss ein Datum vor dem :date sein.',
    'before_or_equal' => 'Das :attribute muss ein Datum vor oder gleich dem :date sein.',
    'between' => [
        'numeric' => 'Das :attribute muss zwischen :min und :max liegen.',
        'file' => 'Das :attribute muss zwischen :min und :max Kilobytes groß sein.',
        'string' => 'Das :attribute muss zwischen :min und :max Zeichen lang sein.',
        'array' => 'Das :attribute muss zwischen :min und :max Elemente haben.',
    ],
    'boolean' => 'Das :attribute Feld muss wahr oder falsch sein.',
    'confirmed' => 'Die :attribute Bestätigung stimmt nicht überein.',
    'date' => 'Das :attribute ist kein gültiges Datum.',
    'date_equals' => 'Das :attribute muss ein Datum gleich dem :date sein.',
    'date_format' => 'Das :attribute entspricht nicht dem Format :format.',
    'different' => 'Das :attribute und :other müssen verschieden sein.',
    'digits' => 'Das :attribute muss :digits Ziffern lang sein.',
    'digits_between' => 'Das :attribute muss zwischen :min und :max Ziffern lang sein.',
    'dimensions' => 'Das :attribute hat ungültige Bildabmessungen.',
    'distinct' => 'Das :attribute Feld hat einen doppelten Wert.',
    'email' => 'Das :attribute muss eine gültige E-Mail-Adresse sein.',
    'ends_with' => 'Das :attribute muss mit einem der folgenden enden: :values.',
    'exists' => 'Das ausgewählte :attribute ist ungültig.',
    'file' => 'Das :attribute muss eine Datei sein.',
    'filled' => 'Das :attribute Feld muss einen Wert haben.',
    'gt' => [
        'numeric' => 'Das :attribute muss größer als :value sein.',
        'file' => 'Das :attribute muss größer als :value Kilobytes sein.',
        'string' => 'Das :attribute muss mehr als :value Zeichen haben.',
        'array' => 'Das :attribute muss mehr als :value Elemente haben.',
    ],
    'gte' => [
        'numeric' => 'Das :attribute muss größer oder gleich :value sein.',
        'file' => 'Das :attribute muss größer oder gleich :value Kilobytes sein.',
        'string' => 'Das :attribute muss größer oder gleich :value Zeichen sein.',
        'array' => 'Das :attribute muss :value oder mehr Elemente haben.',
    ],
    'image' => 'Das :attribute muss ein Bild sein.',
    'in' => 'Das ausgewählte :attribute ist ungültig.',
    'in_array' => 'Das :attribute Feld existiert nicht in :other.',
    'integer' => 'Das :attribute muss eine ganze Zahl sein.',
    'ip' => 'Das :attribute muss eine gültige IP-Adresse sein.',
    'ipv4' => 'Das :attribute muss eine gültige IPv4-Adresse sein.',
    'ipv6' => 'Das :attribute muss eine gültige IPv6-Adresse sein.',
    'json' => 'Das :attribute muss ein gültiger JSON-String sein.',
    'lt' => [
        'numeric' => 'Das :attribute muss kleiner als :value sein.',
        'file' => 'Das :attribute muss kleiner als :value Kilobytes sein.',
        'string' => 'Das :attribute muss weniger als :value Zeichen haben.',
        'array' => 'Das :attribute muss weniger als :value Elemente haben.',
    ],
    'lte' => [
        'numeric' => 'Das :attribute muss kleiner oder gleich :value sein.',
        'file' => 'Das :attribute muss kleiner oder gleich :value Kilobytes sein.',
        'string' => 'Das :attribute muss kleiner oder gleich :value Zeichen sein.',
        'array' => 'Das :attribute darf nicht mehr als :value Elemente haben.',
    ],
    'max' => [
        'numeric' => 'Das :attribute darf nicht größer als :max sein.',
        'file' => 'Das :attribute darf nicht größer als :max Kilobytes sein.',
        'string' => 'Das :attribute darf nicht mehr als :max Zeichen sein.',
        'array' => 'Das :attribute darf nicht mehr als :max Elemente haben.',
    ],
    'mimes' => 'Das :attribute muss eine Datei des Typs: :values sein.',
    'mimetypes' => 'Das :attribute muss eine Datei des Typs: :values sein.',
    'min' => [
        'numeric' => 'Das :attribute muss mindestens :min sein.',
        'file' => 'Das :attribute muss mindestens :min Kilobytes sein.',
        'string' => 'Das :attribute muss mindestens :min Zeichen lang sein.',
        'array' => 'Das :attribute muss mindestens :min Elemente haben.',
    ],
    'not_in' => 'Das ausgewählte :attribute ist ungültig.',
    'not_regex' => 'Das :attribute Format ist ungültig.',
    'numeric' => 'Das :attribute muss eine Zahl sein.',
    'password' => 'Das Passwort ist falsch.',
    'present' => 'Das :attribute Feld muss vorhanden sein.',
    'regex' => 'Das :attribute Format ist ungültig.',
    'required' => 'Das :attribute Feld wird benötigt.',
    'required_if' => 'Das :attribute Feld wird benötigt, wenn :other :value ist.',
    'required_unless' => 'Das :attribute Feld wird benötigt, es sei denn :other befindet sich in :values.',
    'required_with' => 'Das :attribute Feld wird benötigt, wenn :values vorhanden ist.',
    'required_with_all' => 'Das :attribute Feld wird benötigt, wenn :values vorhanden sind.',
    'required_without' => 'Das :attribute Feld wird benötigt, wenn :values nicht vorhanden ist.',
    'required_without_all' => 'Das :attribute Feld wird benötigt, wenn keines von :values vorhanden ist.',
    'same' => 'Das :attribute und :other müssen übereinstimmen.',
    'size' => [
        'numeric' => 'Das :attribute muss :size sein.',
        'file' => 'Das :attribute muss :size Kilobytes sein.',
        'string' => 'Das :attribute muss :size Zeichen lang sein.',
        'array' => 'Das :attribute muss :size Elemente enthalten.',
    ],
    'starts_with' => 'Das :attribute muss mit einem der folgenden beginnen: :values.',
    'string' => 'Das :attribute muss ein String sein.',
    'timezone' => 'Das :attribute muss eine gültige Zone sein.',
    'unique' => 'Das :attribute wurde bereits vergeben.',
    'uploaded' => 'Das :attribute konnte nicht hochgeladen werden.',
    'url' => 'Das :attribute Format ist ungültig.',
    'uuid' => 'Das :attribute muss eine gültige UUID sein.',

    /*
    |--------------------------------------------------------------------------
    | Benutzerdefinierte Validierungs-Sprachzeilen
    |--------------------------------------------------------------------------
    |
    | Hier kannst du benutzerdefinierte Validierungsnachrichten für Attribute
    | angeben, indem du die Konvention "attribute.rule" verwendest, um die
    | Zeilen zu benennen. Dies erleichtert die Spezifizierung einer bestimmten
    | benutzerdefinierten Sprachzeile für eine gegebene Attributregel.
    |
    */

    'custom' => [
        'attribut-name' => [
            'regel-name' => 'benutzerdefinierte-Nachricht',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Benutzerdefinierte Validierungs-Attribute
    |--------------------------------------------------------------------------
    |
    | Die folgenden Sprachzeilen werden verwendet, um unseren Attribut-Platzhalter
    | mit etwas leserfreundlicherem zu tauschen, wie zum Beispiel "E-Mail-Adresse"
    | anstatt "email". Dies hilft uns, unsere Nachricht ausdrucksstärker zu machen.
    |
    */

    'attributes' => [],

];
