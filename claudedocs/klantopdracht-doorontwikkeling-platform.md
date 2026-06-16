# Opdrachtbriefing — Doorontwikkeling FreelanceHub

**Van:** Sanne de Vries, eigenaar & product owner FreelanceHub
**Aan:** het ontwikkelteam (5 developers)
**Betreft:** nieuwe functionaliteiten voor het platform
**Project:** blok 8 — sprintperiode

---

## Beste team,

Bedankt dat jullie de doorontwikkeling van **FreelanceHub** oppakken. Even kort wie wij zijn: FreelanceHub is een marktplaats waar opdrachtgevers (clients) klussen plaatsen en freelancers daarop kunnen solliciteren of een bieding doen. Klanten kunnen na afloop een review achterlaten. Het platform draait, maar mijn gebruikers lopen tegen een aantal dingen aan en ik krijg er dagelijks mailtjes over.

Hieronder beschrijf ik **wat ik graag wil kunnen** — niet hóe jullie het bouwen, dat laat ik aan jullie als professionals. Bij elke wens staat duidelijk wanneer ik hem als **"af"** beschouw (de acceptatiecriteria). Die criteria gebruik ik bij de oplevering om te bepalen of de functie goedgekeurd wordt.

Jullie zijn met z'n vijven. Verdeel het werk zoals jullie willen, maar ik verwacht dat elke wens aan het eind van de sprint **werkend, getest en gedemonstreerd** wordt opgeleverd. Een functie die niet getest is, beschouw ik niet als af.

Met vriendelijke groet,
**Sanne**

---

## Hoe lees je deze briefing

- Elke wens is een **feature** met een korte toelichting, een of meer **user stories** ("Als … wil ik … zodat …") en een lijst **acceptatiecriteria**.
- De acceptatiecriteria zijn **toetsbaar**: ze zijn waar of niet waar. Twijfel je of iets erbij hoort? Stel het me tijdens de sprint.
- Per feature staat een indicatie **basis / uitbreiding / expert**. De basis moet áf zijn voordat jullie aan uitbreidingen beginnen.
- Verdeel de features over het team. Ik adviseer: ieder teamlid trekt minimaal één feature en helpt mee bij een ander.

---

## Feature 1 — Opdrachten kunnen opslaan (favorieten)

**Toelichting:**
Freelancers vertellen me dat ze interessante opdrachten kwijtraken in de lijst. Ze willen klussen kunnen "bewaren" om er later op terug te komen, zoals een verlanglijst in een webshop.

**User story:**
> Als **freelancer** wil ik een opdracht kunnen opslaan als favoriet, zodat ik hem later makkelijk terugvind zonder opnieuw te zoeken.

**Acceptatiecriteria (basis):**
- [ ] Een ingelogde freelancer ziet bij elke opdracht een knop of icoon om hem op te slaan.
- [ ] Klikken op de knop slaat de opdracht op; nogmaals klikken verwijdert hem weer (aan/uit).
- [ ] Er is een aparte pagina "Mijn favorieten" met alleen de opgeslagen opdrachten.
- [ ] Een opdracht kan nooit dubbel in de favorieten staan.
- [ ] Een niet-ingelogde bezoeker kan geen favorieten opslaan.

**Acceptatiecriteria (uitbreiding):**
- [ ] In het menu staat een teller met het aantal favorieten (bijv. "Favorieten (3)").
- [ ] Vanuit "Mijn favorieten" kan de freelancer een opdracht direct openen of verwijderen.

**Acceptatiecriteria (expert):**
- [ ] Op het dashboard van de opdrachtgever zie ik hoe vaak mijn opdracht is opgeslagen ("5 freelancers vonden dit interessant").

---

## Feature 2 — Meldingen binnen het platform

**Toelichting:**
Op dit moment krijgen gebruikers alleen e-mails als er iets gebeurt. Veel gebruikers lezen die niet of te laat. Ik wil dat meldingen **ook in het platform zelf** zichtbaar zijn, met een belletje bovenin.

**User stories:**
> Als **opdrachtgever** wil ik een melding in het platform krijgen als iemand op mijn opdracht solliciteert, zodat ik snel kan reageren.
> Als **freelancer** wil ik een melding krijgen als mijn sollicitatie of bieding wordt geaccepteerd of afgewezen, zodat ik weet waar ik aan toe ben.

**Acceptatiecriteria (basis):**
- [ ] Bij een nieuwe sollicitatie of bieding ontvangt de juiste gebruiker een melding.
- [ ] Bovenin het scherm staat een belletje met het aantal **ongelezen** meldingen.
- [ ] In een meldingenoverzicht zie ik mijn meldingen met de nieuwste bovenaan.
- [ ] Een gebruiker ziet alleen zijn eigen meldingen, nooit die van een ander.

**Acceptatiecriteria (uitbreiding):**
- [ ] Klikken op een melding markeert die als gelezen en brengt me naar de juiste opdracht.
- [ ] Er is een knop "alles als gelezen markeren".

**Acceptatiecriteria (expert):**
- [ ] De teller bij het belletje werkt bij zonder dat ik de pagina hoef te verversen.

---

## Feature 3 — Beter zoeken en filteren

**Toelichting:**
De lijst met opdrachten wordt langer en gebruikers verdwalen erin. Ik wil dat freelancers gericht kunnen filteren op wat voor hen relevant is.

**User story:**
> Als **freelancer** wil ik opdrachten kunnen filteren op categorie, budget en deadline, zodat ik alleen de klussen zie die bij mij passen.

**Acceptatiecriteria (basis):**
- [ ] Op de opdrachtenpagina kan ik filteren op **categorie**.
- [ ] Ik kan filteren op een **minimum- en/of maximumbudget**.
- [ ] De gekozen filters blijven zichtbaar/actief nadat de lijst is ververst.
- [ ] Als er geen resultaten zijn, zie ik een nette melding in plaats van een lege pagina.

**Acceptatiecriteria (uitbreiding):**
- [ ] Ik kan de lijst sorteren (bijv. nieuwste eerst, hoogste budget eerst, deadline dichtbij).
- [ ] Filters zijn te combineren met de bestaande zoekfunctie (zoekwoord + categorie samen).

**Acceptatiecriteria (expert):**
- [ ] Filters staan in de URL, zodat ik een gefilterde lijst kan delen of bookmarken.

---

## Feature 4 — "Past bij jou": opdrachten op basis van skills

**Toelichting:**
Freelancers hebben skills in hun profiel staan en opdrachten horen bij een categorie. Ik wil freelancers helpen door opdrachten te tonen die bij hun skills passen.

**User story:**
> Als **freelancer** wil ik zien welke opdrachten aansluiten op mijn skills, zodat ik sneller passende klussen vind.

**Acceptatiecriteria (basis):**
- [ ] Op het freelancer-dashboard staat een lijstje "Past bij jou" met opdrachten die aansluiten op zijn skills.
- [ ] Een freelancer zonder ingevulde skills ziet een nette uitnodiging om skills toe te voegen.
- [ ] Opdrachten van de freelancer zelf (indien van toepassing) of al gesloten opdrachten staan er niet tussen.

**Acceptatiecriteria (uitbreiding):**
- [ ] Bij elke voorgestelde opdracht is zichtbaar wáárom hij past (bijv. "matcht op: PHP, Laravel").
- [ ] De suggesties zijn gesorteerd op het aantal overeenkomende skills (beste match eerst).

**Acceptatiecriteria (expert):**
- [ ] Bij een opdracht zie ik als opdrachtgever een korte lijst freelancers van wie de skills goed passen.

---

## Feature 5 — Visueel dashboard met cijfers

**Toelichting:**
Als eigenaar wil ik in één oogopslag zien hoe het platform draait. Nu zie ik vooral lijstjes. Ik wil **cijfers en een grafiek**.

**User stories:**
> Als **beheerder** wil ik kerncijfers en een grafiek op mijn dashboard, zodat ik snel inzicht heb in de status van het platform.
> Als **freelancer** wil ik mijn eigen prestaties terugzien, zodat ik weet hoe ik ervoor sta.

**Acceptatiecriteria (basis):**
- [ ] Het beheerdersdashboard toont minimaal 3 kerncijfers (bijv. aantal open opdrachten, totaal gebruikers, gemiddelde beoordeling).
- [ ] Er staat minimaal één grafiek op het dashboard (bijv. opdrachten per categorie).
- [ ] Alle getallen komen uit de database en kloppen met de werkelijke gegevens (niet hardcoded).

**Acceptatiecriteria (uitbreiding):**
- [ ] Het freelancer-dashboard toont persoonlijke cijfers (bijv. aantal geaccepteerde opdrachten, gemiddelde beoordeling).
- [ ] Er is een grafiek "opdrachten per maand".

**Acceptatiecriteria (expert):**
- [ ] Ik kan de cijfers filteren op periode (laatste 7, 30 of 90 dagen).

---

## Feature 6 — Berichten tussen opdrachtgever en freelancer

**Toelichting:**
Voordat een opdracht wordt toegekend, willen partijen vaak even overleggen. Nu gebeurt dat buiten het platform om en raak ik het overzicht kwijt. Ik wil een eenvoudige berichtenfunctie binnen FreelanceHub.

**User story:**
> Als **opdrachtgever of freelancer** wil ik kunnen chatten over een opdracht, zodat we vragen kunnen stellen zonder het platform te verlaten.

**Acceptatiecriteria (basis):**
- [ ] Op een opdracht kunnen de betrokken opdrachtgever en freelancer berichten naar elkaar sturen.
- [ ] Berichten worden getoond met afzender en tijdstip, oudste boven, nieuwste onder.
- [ ] Alleen de betrokkenen bij die opdracht kunnen de berichten lezen — niemand anders.
- [ ] Een leeg bericht kan niet worden verstuurd.

**Acceptatiecriteria (uitbreiding):**
- [ ] Bij een nieuw bericht krijgt de ontvanger een melding (sluit aan op Feature 2).
- [ ] In een overzicht zie ik al mijn gesprekken met het laatste bericht als voorbeeld.

**Acceptatiecriteria (expert):**
- [ ] Nieuwe berichten verschijnen zonder dat ik de pagina hoef te verversen.

---

## Algemene eisen (gelden voor élke feature)

Deze eisen gelden voor alles wat jullie opleveren. Ik toets hier ook op bij de oplevering.

- [ ] **Rechten kloppen:** een gebruiker kan alleen doen en zien wat bij zijn rol hoort (client / freelancer / admin). Niemand komt bij data van een ander.
- [ ] **Foutafhandeling:** bij verkeerde invoer krijgt de gebruiker een nette melding, geen technische foutpagina.
- [ ] **Werkt op mobiel en desktop:** de nieuwe schermen zijn ook op een telefoon bruikbaar.
- [ ] **Past in de stijl:** de nieuwe onderdelen sluiten qua uiterlijk aan op de rest van het platform.
- [ ] **Getest:** elke feature heeft geautomatiseerde tests die aantonen dat hij werkt. Niet getest = niet af.
- [ ] **Demonstreerbaar:** jullie kunnen de feature live laten zien tijdens de sprintdemo.

---

## Opleverafspraken

- **Sprintdemo:** aan het eind van de sprint laten jullie de werkende features zien. Loop daarbij per feature de acceptatiecriteria langs.
- **Verantwoording:** licht kort toe welke keuzes jullie gemaakt hebben en waarom (max. een paar minuten per feature).
- **Taakverdeling:** geef aan wie wat heeft gedaan, zodat ik weet hoe het team heeft samengewerkt.

Succes! Ik kijk uit naar de demo.

— Sanne
