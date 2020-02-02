%% 
clc
clear all
format %将显示格式调为默认（4位小数）
P=[3.2 3.2 3 3.2 3.2 3.4 3.2 3 3.2 3.2 3.2 3.9 3.1 3.2;
9.6 10.3 9 10.3 10.1 10 9.6 9 9.6 9.2 9.5 9 9.5 9.7;
3.45 3.75 3.5 3.65 3.5 3.4 3.55 3.5 3.55 3.5 3.4 3.1 3.6 3.45;
2.15 2.2 2.2 2.2 2 2.15 2.14 2.1 2.1 2.1 2.15 2 2.1 2.15;
140 120 140 150 80 130 130 100 130 140 115 80 90 130;
2.8 3.4 3.5 2.8 1.5 3.2 3.5 1.8 3.5 2.5 2.8 2.2 2.7 4.6;
11 10.9 11.4 10.8 11.3 11.5 11.8 11.3 11.8 11 11.9 13 11.1 10.85;
50 70 50 80 50 60 65 40 65 50 50 50 70 70];
%输入训练集P（正常输入需要转置）
%每一列是一组输入训练集，列数代表输入训练集组数;行数代表【输入层】神经元个数，也即每行代表一个指标
%%
T=[2.24 2.33 2.24 2.32 2.2 2.27 2.2 2.26 2.2 2.24 2.24 2.2 2.2 2.35];
%输出训练集T
%每一列是一组输出训练集，列数代表输出训练集组数（输出1组）
%% 
[p1,minp,maxp,t1,mint,maxt]=premnmx(P,T);
%% 创建网络
net=newff(minmax(P),[8,6,1],{'tansig','tansig','purelin'},'trainlm');
%% 设置训练次数（网络迭代次数epochs为5000次）
net.trainParam.epochs = 5000;
%% 设置收敛误差（期望误差goal为0.00000001）
net.trainParam.goal=0.0000001;
%% 训练网络
[net,tr]=train(net,p1,t1);
TRAINLM, Epoch 0/5000, MSE 0.533351/1e-007, Gradient 18.9079/1e-010
TRAINLM, Epoch 24/5000, MSE 8.81926e-008/1e-007, Gradient 0.0022922/1e-010
TRAINLM, Performance goal met.
%该网络通过24次（epochs=24）重复学习达到期望误差后则完成学习
%% 输入数据（预测运动员的素质指标数据）
a=[3.0;9.3;3.3;2.05;100;2.8;11.2;50];%这是正常运动员，最后预测的跳高高度2.20
%a=[0.3;90.3;30.3;20.05;1000;20.8;1.2;500];%这是超人，最后预测的跳高高度还是2.20
%a=[0;0;0;0;0;0;0;0];%如此，最后预测的跳高高度仍为2.20？？？哪里出了问题？？？
%% 将输入数据归一化
a=premnmx(a);
%% 放入到网络输出数据
b=sim(net,a);
%% 将得到的数据反归一化得到预测数据
c=postmnmx(b,mint,maxt);
c %结果约为2.20（每次预测结果不尽相同）