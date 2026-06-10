# TODO — FreelanceHub

Werklijst voor het ontwikkelteam. De eerste helft zijn **bugs** die nu in het
platform zitten (gevonden tijdens een code-review + testronde). De tweede helft
zijn de **nieuwe features** uit de briefing van Sanne
(`claudedocs/klantopdracht-doorontwikkeling-platform.md`).

> **Werkwijze**
> 1. Werk per taak op een eigen branch: `git checkout -b fix/<korte-naam>`.
> 2. Reproduceer eerst de fout (draai de genoemde test of klik het na in de browser).
> 3. Los het op en schrijf/repareer een test die bewijst dat het werkt.
> 4. Draai `php artisan test --compact` en `vendor/bin/pint` voordat je een PR maakt.
> 5. Een taak is pas "af" als alle acceptatiecriteria afgevinkt zijn én de test groen is.

**Startsituatie:** `php artisan test` → **8 van de 104 tests falen.** Doel: alles groen.

---

## Deel 1 — Bugs

### 🔴 BUG-1 — E-mailverificatie en wachtwoordbevestiging crashen (500)

**Probleem:** Verschillende auth-controllers sturen door naar `route('dashboard')`,
maar die route bestaat niet meer. Er zijn alleen `dashboard.client`,
`dashboard.freelancer` en `dashboard.admin`. Een nieuwe gebruiker die op de
verificatielink in zijn mail klikt, krijgt een `RouteNotFoundException` (500).
Omdat de dashboards de `verified`-middleware hebben, kan zo'n gebruiker nergens komen.

**Waar:**
- `app/Http/Controllers/Auth/VerifyEmailController.php`
- `app/Http/Controllers/Auth/EmailVerificationPromptController.php`
- `app/Http/Controllers/Auth/EmailVerificationNotificationController.php`
- `app/Http/Controllers/Auth/ConfirmablePasswordController.php`

**Reproduceren:** `php artisan test --filter=PasswordConfirmationTest`
(zie ook de stacktrace: `Route [dashboard] not defined`).

**Hint:** Kijk hoe `RegisteredUserController` en `AuthenticatedSessionController`
het al goed doen (doorsturen op basis van rol). Bedenk of je dat patroon wilt
herhalen of er één centrale "stuur-naar-juiste-dashboard"-oplossing van maakt
(bijv. een helper of een algemene `dashboard`-route die zelf doorverwijst).

**Acceptatiecriteria:**
- [ ] Een gebruiker die zijn e-mail verifieert komt zonder fout op zijn eigen dashboard.
- [ ] Wachtwoordbevestiging werkt zonder 500-fout.
- [ ] De betrokken auth-tests zijn groen.

---

### 🔴 BUG-2 — Je kunt jezelf als beheerder registreren

**Probleem:** Het registratieformulier accepteert `role = admin`. Iedere bezoeker
kan dus een beheerdersaccount aanmaken. Dat is een ernstig beveiligingslek.

**Waar:** `app/Http/Controllers/Auth/RegisteredUserController.php` (de `validate`-regels).

**Reproduceren:** `php artisan test --filter="bezoeker kan niet registreren als beheerder"`

**Hint:** Bij registratie horen alleen `client` en `freelancer` toegestaan te zijn.
Admins worden door een beheerder aangemaakt via `UserController`.

**Acceptatiecriteria:**
- [ ] Registreren met `role=admin` geeft een validatiefout, geen account.
- [ ] Registreren als `client` of `freelancer` werkt nog gewoon.
- [ ] Test is groen.

---

### 🔴 BUG-3 — Een client kan opdrachten van een ander bewerken/verwijderen (IDOR)

**Probleem:** `CommissionController::edit`, `update` en `destroy` controleren niet
of de ingelogde gebruiker de **eigenaar** van de opdracht is. De route eist alleen
`role:client`. Dus client A kan via een geraden id (`/commissions/5/edit`) de
opdracht van client B aanpassen of weggooien. Dit schendt de algemene eis
"niemand komt bij data van een ander".

**Waar:** `app/Http/Controllers/CommissionController.php`.

**Hint:** `show()` doet al een eigenaarscontrole — gebruik datzelfde idee.
Mooier (en "the Laravel way") is een **Policy**: `php artisan make:policy CommissionPolicy --model=Commission`
en dan `$this->authorize('update', $commission);` in de controller.

**Let op:** schrijf hier een **nieuwe** test voor (die is er nog niet!): "client kan
opdracht van een andere client NIET bewerken/verwijderen → 403".

**Acceptatiecriteria:**
- [ ] Een client kan alleen zijn eigen opdrachten bewerken en verwijderen.
- [ ] Een poging op andermans opdracht geeft een nette 403.
- [ ] Er is een test die dit aantoont.

---

### 🟠 BUG-4 — Bezoekers kunnen de detailpagina van een opdracht niet zien

**Probleem:** De userstory zegt dat een **bezoeker** (niet ingelogd) de
detailpagina van een opdracht moet kunnen bekijken. Nu zit `commissions/{commission}`
achter `auth + role:client,freelancer`, dus gasten worden weggestuurd. Bovendien
blokkeert `show()` ook ingelogde clients die niet de eigenaar zijn, terwijl een
opdracht juist openbaar hoort te zijn.

**Waar:** `routes/web.php` (de groep rond regel 62) en `CommissionController::show`.

**Reproduceren:** `php artisan test --filter=VisitorTest` →
"bezoeker kan detailpagina van een opdracht zien" (krijgt 302 i.p.v. 200).

**Hint:** Denk goed na over wat openbaar mag zijn (detail bekijken) en wat alleen
voor de eigenaar/ingelogde gebruiker is (bewerken, solliciteren). Haal de
detailpagina uit de afgeschermde groep, maar laat acties zoals solliciteren/bieden
wél achter login.

**Acceptatiecriteria:**
- [ ] Een niet-ingelogde bezoeker kan een opdracht-detailpagina openen (200).
- [ ] Solliciteren/bieden blijft alleen voor ingelogde gebruikers.
- [ ] De VisitorTest-tests zijn groen.

---

### 🟠 BUG-5 — Dubbele routes in `web.php`

**Probleem:** Een paar routes staan dubbel gedefinieerd. De **laatste** definitie
wint in Laravel, en dat zorgt voor verkeerde rechten:
- `applications.store` en `applications.destroy` staan twee keer (rond regel 84 én 92).
- `reviews.index` staat drie keer. De laatste versie staat in een groep met alleen
  `auth`, waardoor de rolbeperking (`role:client,freelancer`) verdwijnt. Daardoor
  kan een **client** de freelancer-pagina `/my-reviews` openen.

**Waar:** `routes/web.php`.

**Reproduceren:** `php artisan test --filter="opdrachtgever heeft geen toegang tot mijn reviews pagina"`

**Hint:** Ruim de dubbele blokken op zodat elke route maar één keer voorkomt, met
de juiste middleware. Controleer met `php artisan route:list` of het klopt.

**Acceptatiecriteria:**
- [ ] Elke route is uniek gedefinieerd.
- [ ] `/my-reviews` is alleen voor freelancers (client krijgt 403).
- [ ] `php artisan route:list` toont geen dubbele namen meer.

---

### 🟡 BUG-6 — Opschoning (kleinere verbeteringen)

Pak deze op als je tijd over hebt; ze zijn niet kritiek maar wel goede vakmanschap-oefeningen.

- [ ] **Afbeelding blijft achter bij verwijderen.** `CommissionController::destroy`
      gooit de opdracht weg maar niet de geüploade afbeelding in `storage`. Verwijder
      het bestand ook (kijk hoe `update()` dat al doet).
- [ ] **`$request->all()` vervangen.** `CommissionController::store/update` gebruiken
      `$request->all()`. Gebruik liever `$request->validate(...)`-resultaat of
      `$request->only([...])`, zodat alleen verwachte velden worden opgeslagen.
- [ ] **Biedingen (`OfferController::store`).** Hier ontbreekt een rolcheck en je
      kunt op je eigen opdracht bieden. Voeg controles toe (alleen freelancers,
      niet op eigen opdracht, niet dubbel bieden).
- [ ] **Profieltest klopt niet meer.** `tests/Feature/ProfileTest.php` stuurt nog
      `name`, terwijl `ProfileUpdateRequest` nu `firstname`/`lastname` eist. Werk de
      test bij zodat de profielfunctie écht getest wordt.

---

## Deel 2 — Nieuwe features (uit de briefing van Sanne)

> De volledige acceptatiecriteria staan in
> `claudedocs/klantopdracht-doorontwikkeling-platform.md`. Hieronder de kern +
> een technische startwijzer. Doe eerst de **basis** voordat je aan uitbreiding/expert begint.
> **Elke feature heeft eigen tests nodig — niet getest = niet af.**

### FEATURE-1 — Opdrachten opslaan als favoriet
Freelancer kan opdrachten bewaren en terugvinden op "Mijn favorieten".
- Startwijzer: koppeltabel `favorites` (user_id + commission_id, uniek samen),
  many-to-many relatie op `User`/`Commission`, toggle-route.
- Basiscriteria: opslaan/verwijderen (toggle), aparte favorietenpagina, nooit
  dubbel, alleen voor ingelogde freelancers.

### FEATURE-2 — Meldingen binnen het platform
In-app meldingen met een belletje + ongelezen-teller.
- Startwijzer: Laravel heeft hiervoor `php artisan notifications:table` +
  database-notifications. Zoek in de docs op "notifications".
- Basiscriteria: melding bij nieuwe sollicitatie/bieding en bij acceptatie/afwijzing,
  belletje met ongelezen aantal, eigen meldingen-overzicht (nieuwste boven),
  je ziet alleen je eigen meldingen.

### FEATURE-3 — Beter zoeken en filteren  ⭐ goede instap
Filteren op categorie, minimum/maximum budget en deadline; filters blijven actief.
- Startwijzer: bouw voort op `CommissionController::index` (daar zit al een
  categorie-/zoekfilter). Voeg `budget_min`, `budget_max`, sortering toe.
- Basiscriteria: filter op categorie + budget, filters blijven zichtbaar na
  verversen, nette melding bij 0 resultaten.

### FEATURE-4 — "Past bij jou" op basis van skills
Freelancer ziet op zijn dashboard opdrachten die matchen met zijn skills.
- Startwijzer: `users.skills` is al een array-veld; opdrachten hangen aan een
  categorie. Bedenk hoe je skills aan categorieën/opdrachten matcht.
- Basiscriteria: lijstje "Past bij jou" op het freelancer-dashboard, nette
  uitnodiging als er geen skills zijn, geen eigen of gesloten opdrachten ertussen.

### FEATURE-5 — Visueel dashboard met cijfers
Beheerdersdashboard met ≥3 kerncijfers en ≥1 grafiek; alles uit de database.
- Startwijzer: aggregaties met Eloquent (`count`, `avg`, `groupBy`). Voor de
  grafiek bijv. Chart.js in een Blade-view.
- Basiscriteria: 3 kerncijfers, 1 grafiek (bijv. opdrachten per categorie), geen
  hardcoded getallen.

### FEATURE-6 — Berichten tussen opdrachtgever en freelancer
Eenvoudige chat per opdracht tussen de betrokken partijen.
- Startwijzer: tabel `messages` (commission_id, sender_id, body, timestamps).
  Let op autorisatie: alleen betrokkenen mogen lezen.
- Basiscriteria: berichten met afzender + tijd (oudste boven), alleen betrokkenen
  kunnen lezen, leeg bericht kan niet verstuurd worden.

---

## Algemene eisen (gelden voor élke taak)
- [ ] **Rechten kloppen** — gebruiker kan alleen wat bij zijn rol hoort; niemand bij data van een ander.
- [ ] **Foutafhandeling** — nette melding bij verkeerde invoer, geen technische foutpagina.
- [ ] **Mobiel + desktop** — nieuwe schermen werken op telefoon én desktop.
- [ ] **Past in de stijl** — sluit aan op de bestaande Tailwind-opmaak.
- [ ] **Getest** — geautomatiseerde test die bewijst dat het werkt.
- [ ] **Demonstreerbaar** — live te laten zien in de sprintdemo.
