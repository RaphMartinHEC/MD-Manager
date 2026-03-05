# Installation

## 1. Installation des paquets (si nécessaire)

```bash
sudo dnf update -y
sudo dnf install -y httpd php php-mbstring php-common php-gd
sudo systemctl enable --now httpd
```

---

## 2. Permissions

Après la copie des fichiers :

```bash
sudo chown -R apache:apache /var/www/html
sudo chmod -R 775 /var/www/html/files
find /var/www/html -type f -exec sudo chmod 644 {} \;
find /var/www/html -type d -exec sudo chmod 755 {} \;
```

---

## 3. SELinux

```bash
sudo chcon -t httpd_sys_rw_content_t /var/www/html/files -R
sudo semanage fcontext -a -t httpd_sys_rw_content_t "/var/www/html/files(/.*)?"
sudo restorecon -Rv /var/www/html/files
```

---

## 4. Firewall (si nécessaire)

```bash
sudo firewall-cmd --permanent --add-service=http
sudo firewall-cmd --permanent --add-service=https
sudo firewall-cmd --reload
```

