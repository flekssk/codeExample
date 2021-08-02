FROM centos:7 as local

RUN yum install -y postgresql-libs \
        unixODBC \
        crond \
        wget \
        cronie \
        mysql

RUN cd \tmp && wget http://sphinxsearch.com/files/sphinx-2.2.11-1.rhel7.x86_64.rpm && \
    yum install -y sphinx-2.2.11-1.rhel7.x86_64.rpm

COPY build/docker/sphinx/configs/ /

RUN mkdir /var/tmp/sphinx/ && \
    chmod 0777 /var/tmp/sphinx/ && \
    chmod 0777 /var/log/sphinx/ && \
    chmod 0777 /opt/start.sh

CMD ["/opt/start.sh"]

FROM local as test

RUN cp /etc/sphinx/sphinx_test.conf /etc/sphinx/sphinx.conf -f

CMD ["/opt/start.sh"]
