### 记录一下平时遇到的比较少用难以记忆的一些Linux知识点
1. 备份命令：
```
tar cvpzf backup.tgz --exclude=/proc --exclude=/lost+found --exclude=/root/backup.tgz --exclude=/mnt --exclude=/sys --exclude=/media  / 
```

2. 查看目录大小：
```
du -sh
du -h --max-depth 1
du -Sh 
```

3. 返回上次命令行位置：
```
cd -
```

4. ssh秘钥免密登录
```
1.ssh-keygen -t rsa #创建公钥
2.scp /root/.ssh/id_rsa.pub root@45.32.30.198:~/.ssh
3.cat id_rsa.pub >> authorized_keys
```

5. 端口占用情况
```
netstat -anp
```

6. 格式化U盘
```
fdisk -l
fdisk /dev/sdc
mkfs -t ntfs /dev/sdc1
```

7. 后台运行命令
```
nohup ping 192.168.2.1 >> no.log 2>&1 &
```

8. crontab定时任务
```
minute： 表示分钟，可以是从0到59之间的任何整数
hour：表示小时，可以是从0到23之间的任何整数
day：表示日期，可以是从1到31之间的任何整数
month：表示月份，可以是从1到12之间的任何整数
week：表示星期几，可以是从0到7之间的任何整数，这里的0或7代表星期日
command：要执行的命令，可以是系统命令，也可以是自己编写的脚本文件。
*/5 * * * * command     #每5分钟执行一次
* * * * * co
```
9. 语言包问题
```
export LANGUAGE=zh_CN.UTF-8
export LANG=zh_CN.UTF-8
export LC_ALL=zh_CN.UTF-8
sudo locale-gen zh_CN.UTF-8
vim /etc/default/locale
LANG="en_US.UTF-8"
LANGUAGE="en_US.UTF-8"
LC_ALL="en_US.UTF-8"
apt-get install language-pack-en-base  
vagrant plugin install vagrant-vbguest
```

10. 测速软件
```
apt-get install python-pippip install speedtest-clispeedtest-cli
```
11. docker
```
docker run -it --add-host localmysql:127.0.0.1 -p 192.168.0.109:8080:80  -v /home/jwang/Documents/work/ycg:/var/www/ycg ubuntu:14.10
```

12. 设置ubuntu系统cpu调度器为performance
```
sudo vim /etc/init.d/cpufrequtilsGOVERNOR="performance"
```

13. sudo不用输密码
```
my-username ALL=(ALL) NOPASSWD: ALL
```
14. 切换PHP版本
```
sudo update-alternatives --query php
sudo update-alternatives --set php /usr/bin/php5.6
```

15. mysql开启远程访问
```
1.bind_address 注释掉
2.grant all on *.* to root@'%' identified by 'password';
```

16. unzip解压中文乱码
```
 unzip -O CP936 xxx.zip (用GBK, GB18030也可以)
```

17. 开机自启 
```
sudo update-rc.d   apache2 defaults 
sudo update-rc.d -f apache2 remove
```
18. 时区问题
```
hwclock -r  #查看时钟
date  #查看时间
tzselect #选择时区
TZ='Asia/Shanghai'; export TZ #设置时区
```
19. 流量监控
```
sudo add-apt-repository ppa:nilarimogard/webupd8
sudo apt-get install indicator-netspeed
```
20. Ubuntu设置CPU governor
```
sudo apt-get install cpufrequtils
sudo cpufreq-set -r -g performance
``` 
21.合并音视频
```
sudo ffmpeg -i out.mp4 -i sound.mp3 -vcodec copy -acodec copy out.mp4
```
22.查找kill进程
```
sudo ps -axu|grep QQ |awk -F" " '{print $2}'|xargs kill -9
```