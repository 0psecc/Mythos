## Het probleem (HTTPS)

Wanneer een gebruiker een bestand upload, wordt het bestand van de browser naar de server gestuurd.

**Zonder HTTPS** kunnen andere mensen op hetzelfde netwerk mogelijk zien welke gegevens worden verstuurd.

**Met HTTPS** wordt de verbinding beveiligd met TLS (Transport Layer Security). Hierdoor worden bestanden versleuteld verstuurd en kunnen anderen de inhoud niet zomaar bekijken.

## Encryptie van bestanden

Naast HTTPS worden bestanden ook versleuteld opgeslagen op de server.

Hiervoor gebruiken we **AES-256** encryptie. Voordat een bestand wordt opgeslagen, wordt het eerst versleuteld. Hierdoor zijn bestanden in de uploadmap niet direct leesbaar.

Wanneer een gebruiker een bestand downloadt, wordt het bestand automatisch ontsleuteld.

## Testen

Om te controleren of HTTPS werkt, moet de URL beginnen met:

```text
https://
```

Daarnaast controleert de applicatie in de code of HTTPS actief is voordat een upload wordt toegestaan.

Bestanden worden opgeslagen met de extensie `.enc`. Dit laat zien dat het bestand versleuteld is opgeslagen.

## Sources

Document:

https://docs.google.com/document/d/1efiHoAXwd3X-kbULZATNIH91KQCMsJkHBHqyT5vuLOQ/edit

Trello:

https://trello.com/b/N0ppxBxj/mijn-trello-bord

TLS (Cloudflare):

https://www.cloudflare.com/learning/ssl/transport-layer-security-tls/

AES-256 Encryptie:

https://www.aeanet.org/what-is-aes-256-encryption/

## Contributors

* **[@0psecc](https://github.com/0psecc)**

* **[@Finn740](https://github.com/Finn740)**

* **[@Ryan10283](https://github.com/Ryan10283)**

* **[@SwimmingTrunk](https://github.com/SwimmingTrunk)**
