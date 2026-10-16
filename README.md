# TS-Barbershop

WordPress-thema (`ts-barbershop/`) voor de nieuwe website van Barbershop Oosterbeek. Kleuren en lettertype komen van de huidige site: rood `#f25b3a`, donker `#333`, tekst `#666`, licht `#efefef`, Open Sans.

De repo bevat alleen het thema. WordPress zelf en de database draaien lokaal in LocalWP.

## Lokaal draaien
1. Installeer [LocalWP](https://localwp.com) en maak een site aan, bijvoorbeeld `barbershop-oosterbeek`.
2. Koppel het thema met een symlink (pas het pad naar je repo aan):
   ```
   ln -s /pad/naar/TS-Barbershop/ts-barbershop ~/Local\ Sites/barbershop-oosterbeek/app/public/wp-content/themes/ts-barbershop
   ```
3. Activeer het thema **TS Barbershop** in WordPress (Weergave > Thema's).
4. Installeer en activeer de plugin **Salon Booking System**. Open daarna één keer WP Admin: het thema zet dan automatisch de 6 behandelingen (30 min, prijzen van de oude site) als diensten in de plugin, stelt de pagina **Afspraak maken** (`/afspraak/`) in als boekingspagina en zet de valuta op euro. Bestaande diensten blijven ongemoeid. Handmatig starten kan met `wp eval 'tsb_sync_services();'`. Vul de openingstijden in de plugin zelf in.
   Klik je op de homepage een behandeling aan, dan ga je naar `/afspraak/` met die dienst al aangevinkt. Zet in Instellingen > Permalinks de structuur op **Berichtnaam**.
5. De pagina **Foto galerij** (`/foto-galerij/`) wordt door het thema aangemaakt. Zonder inhoud toont hij alle foto's uit `ts-barbershop/assets/img/galerij/` (zet daar nieuwe foto's neer, de volgorde is op bestandsnaam). Wil je liever beheren in WordPress, zet dan een Galerij-blok in de pagina: dan toont het thema dat in plaats van de map. Foto's openen groot met bladeren.
6. Zet in Instellingen > Algemeen de sitetitel op **Barbershop Oosterbeek**; die staat in de voet.
7. Stel in Instellingen > Lezen in dat de voorpagina **Je laatste berichten** is. `front-page.php` wordt dan altijd gebruikt.
8. Pas adres, telefoon, openingstijden, prijslijst en annuleringsbeleid aan via Weergave > Customizer > **Barbershop gegevens**.

## Daarna
Klant laten meekijken via een staging-link, feedback verwerken en live zetten.
