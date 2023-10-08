ARG POSTGRES_VERSION=12.2
FROM postgres:$POSTGRES_VERSION

RUN apt-get update \
    && apt-get install -y \
    # Builds utils
    build-essential \
    gettext-base \
    git-core \
    curl \
    ca-certificates \
    libsybdb5 \
    freetds-dev \
    freetds-common \
    freetds-bin \
    gcc \
    make \
    # required by pgtap
    libv8-dev \
    postgresql-server-dev-$PG_MAJOR \
    postgresql-pltcl-$PG_MAJOR \
    postgresql-plperl-$PG_MAJOR \
    cpanminus \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN cpanm TAP::Parser::SourceHandler::pgTAP

# install pgtap
RUN git clone https://github.com/theory/pgtap.git \
    && cd pgtap \
    && make \
    && make install \
    && make clean

# install tds_fdw
RUN git clone https://github.com/tds-fdw/tds_fdw.git \
    && cd tds_fdw \
    && git checkout tags/v2.0.2 \
    && make USE_PGXS=1 \
    && make USE_PGXS=1 install \
    && sed -i '/# TDS protocol version/a \\ttds version=7.0' /etc/freetds/freetds.conf

RUN apt-get -y remove git-core

# additional confs append to postgresql.conf
RUN cat /usr/share/postgresql/postgresql.conf.sample > /etc/postgresql/postgresql.conf
RUN echo "search_path = 'public'" >> /etc/postgresql/postgresql.conf
RUN echo "shared_preload_libraries = 'pg_stat_statements'" >> /etc/postgresql/postgresql.conf

CMD ["-c", "config_file=/etc/postgresql/postgresql.conf"]