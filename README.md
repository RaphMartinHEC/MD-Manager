# Installation

## 1. Installation des paquets

```bash
dnf update -y
dnf install -y httpd php php-mbstring php-common php-gd
systemctl enable --now httpd
```

---

## 2. Création des dossiers et permissions

```bash
mkdir -p /var/www/html/mdmanager/files
```

Après la copie des fichiers :

```bash
chown -R apache:apache /var/www/html
chmod -R 775 /var/www/html/mdmanager/files
find /var/www/html -type f -exec sudo chmod 644 {} \;
find /var/www/html -type d -exec sudo chmod 755 {} \;
```

---

## 3. SELinux

```bash
chcon -t httpd_sys_rw_content_t /var/www/html/mdmanager/files -R
restorecon -Rv /var/www/html/mdmanager/files
```

---

## 4. Firewall (Si pas déjà fait)

```bash
firewall-cmd --permanent --add-service=http
firewall-cmd --permanent --add-service=https
firewall-cmd --reload
```

