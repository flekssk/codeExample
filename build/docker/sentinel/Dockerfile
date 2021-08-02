FROM redis:3.2

COPY configs/ /

RUN chown redis:redis /etc/redis/sentinel.conf \
    && chmod +x /opt/start.sh \
    && mkdir -p /var/www/log \
    && chmod o+w /var/www/log

# ENTRYPOINT
CMD sh /opt/start.sh