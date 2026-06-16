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

All fixed! 

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
