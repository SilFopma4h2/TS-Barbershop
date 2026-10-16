# TS-Barbershop

WordPress-thema (`ts-barbershop/`) voor de nieuwe website van Barbershop Oosterbeek. Kleuren en lettertype komen van de huidige site: rood `#ee1d23`, donker `#333`, tekst `#666`, licht `#efefef`, Open Sans.

De repo bevat alleen het thema. WordPress zelf en de database draaien lokaal in LocalWP.

## Lokaal draaien
1. Installeer [LocalWP](https://localwp.com) en maak een site aan, bijvoorbeeld `barbershop-oosterbeek`.
2. Koppel het thema met een symlink (pas het pad naar je repo aan):
   ```
   ln -s /pad/naar/TS-Barbershop/ts-barbershop ~/Local\ Sites/barbershop-oosterbeek/app/public/wp-content/themes/ts-barbershop
   ```
3. Activeer het thema **TS Barbershop** in WordPress (Weergave > Thema's).
4. Installeer en activeer de plugin **Salon Booking System**. Vul diensten (30 min), prijzen en openingstijden in. De homepage toont de agenda automatisch via `[salon]`.
5. Maak een pagina **Foto galerij** (slug `foto-galerij`) met de galerij-plugin of het Gallery-blok.
6. Stel in Instellingen > Lezen in dat de voorpagina **Je laatste berichten** is. `front-page.php` wordt dan altijd gebruikt.
7. Pas adres, telefoon, openingstijden, prijslijst en annuleringsbeleid aan via Weergave > Customizer > **Barbershop gegevens**.

## Daarna
Klant laten meekijken via een staging-link, feedback verwerken en live zetten.
