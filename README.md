# Installation

## 1. Installation des paquets

```bash
dnf update -y
dnf install -y httpd git php php-mbstring php-common php-gd policycoreutils-python-utils
systemctl enable --now httpd
```

---

## 2. Téléchargement des fichiers et permissions

```bash
git clone https://github.com/RaphMartinHEC/MD-Manager.git
mv ./MD-Manager/mdmanager /var/www/html
mkdir -p /var/www/html/mdmanager/files
chown -R apache:apache /var/www/html
find /var/www/html -type f -exec chmod 644 {} \;
find /var/www/html -type d -exec chmod 755 {} \;
chmod -R 775 /var/www/html/mdmanager/files
rm -rf ./MD-Manager
```

---

## 3. SELinux (Si actif)

```bash
restorecon -Rv /var/www/html/mdmanager
semanage fcontext -a -t httpd_sys_rw_content_t "/var/www/html/mdmanager/files(/.*)?"
restorecon -Rv /var/www/html/mdmanager/files
```

---

## 4. Firewall (Si pas déjà fait)

```bash
firewall-cmd --permanent --add-service=http
firewall-cmd --permanent --add-service=https
firewall-cmd --reload
```






