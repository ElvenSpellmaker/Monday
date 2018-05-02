FROM elvenspellmaker/php-cli:latest

WORKDIR /data

RUN yum install php72w-xml -y

COPY . ./

CMD ["bash", "bin/docker-run.bash"]
