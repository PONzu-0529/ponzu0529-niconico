FROM centos:centos7

# define
ARG SELENIUM_SERVER_PORT

# install
RUN yum -y update && \
    yum -y install sudo wget unzip java

WORKDIR /var

# install google-chrome
RUN wget http://dist.control.lth.se/public/CentOS-7/x86_64/google.x86_64/Packages/google-chrome-stable-71.0.3578.98-1.x86_64.rpm && \
    yum -y localinstall google-chrome-stable-71.0.3578.98-1.x86_64.rpm

# install chromedriver
RUN wget https://chromedriver.storage.googleapis.com/70.0.3538.97/chromedriver_linux64.zip && \
    unzip chromedriver_linux64.zip

# install selenium-server
RUN wget https://github.com/SeleniumHQ/selenium/releases/download/selenium-4.4.0/selenium-server-4.4.0.jar

# Copy and Setting Startup Script
COPY startup.sh /var/startup.sh
RUN chmod 700 /var/startup.sh

CMD /var/startup.sh ${SELENIUM_SERVER_PORT} && /bin/bash
