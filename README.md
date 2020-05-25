You need virgil_crypto_php before you start, check web.php / route to make a check for extension.

Check following repo for more:

https://github.com/VirgilSecurity/demo-backend-php

---

How can we do e2e for teams, SaaS Applications.

Each Team has a KeyPair - PublicKey is uploaded to Cloud, PrivateKey is uploaded to Cloud after encrypting it with BackupPassword.

Encrypt all data with TeamPublicKey

Team members can only decrypt with TeamPrivateKey

The whole goal is to send TeamPrivateKey safely to Team Members

## teams

name
owner_id
public_key
private_key (encrypted with team backup password)

## team_members

team_id
user_id
private_key (encrypted with user public key)

## users

email
public_key
private_key (encrypted with user backup password)

---

As soon as a user is created - We create user_public_key, user_private_key, ask for backup password and upload public_key and private_key (after encryption)
User now creates a team - We create team_public_key, team_private_key, ask for backup password and upload public_key and private_key (after encryption)
Add current user to team_members - Take user_public_key, encrypt team_private_key and store it in team_members table

---

When a user logins, this is what we need to do:

1. Check if local has user_public_key, user_private_key
    1. If there is no such key, download from cloud - If user enters correct backup password
    2. After a team is chosen, download team_members private_key, decrypt it.

In case of client,

1. After choosing a case, download respective key again.
